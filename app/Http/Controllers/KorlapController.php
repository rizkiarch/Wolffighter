<?php

namespace App\Http\Controllers;

use App\Models\Korlap;
use App\Models\Organisasi;
use App\Models\Region;
use App\Models\SubRegion;
use App\Models\User;
use App\Models\Wilayah;
use App\Utils\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KorlapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organisasi_id = $request->input(('organisasi_id'));
        $search = $request->input('search');

        $korlaps = Korlap::with(([
            'organisasi',
            'user',
            'details',
            'details.user',
            'user.wilayah',
        ]))->when($search, function ($query, $search) {
            return $query->where('nik', 'like', "%$search%");
        })->when($organisasi_id, function ($query, $organisasi_id) {
            return $query->where('organisasi_id',  "$organisasi_id");
        })->get();

        $users = User::all();
        $organisasis = Organisasi::all();
        return inertia('data/korlap.index', [
            'organisasis' => $organisasis,
            'korlaps' => $korlaps,
            'users' => $users,
            'title' => 'Data Organisasi'
        ]);
    }

    public function pesertaKorlap(request $request)
    {
        $data = [
            'nik' => $request->input('nik'),
            'user_id' => $request->input('user_id'),
        ];

        $user = User::findOrFail($data['user_id']);
        $data['no'] = IdGenerator::generate([
            'table' => 'korlaps',
            'field' => 'no',
            'length' => 15,
            'reset_on_prefix_change' => true,
            'prefix' => $user->no . "."
        ]);
        // dd($data);
        Korlap::create($data);
        return redirect()
            ->route('korlap.index')
            ->with('success', 'data berhasil ditambahkan');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // mengambil wilayah
        $prov_id = $request->input('prov_id');
        $kab_id = $request->input('kab_id');
        $kec_id = $request->input('kec_id');
        $region_id = $request->input('region_id');

        $prov = Wilayah::where('parent', 0)->orderBy('name', 'asc')->get();
        $kab = Wilayah::where('parent', $prov_id)->orderBy('name', 'asc')->get();
        $kec = Wilayah::where('parent', $kab_id)->orderBy('name', 'asc')->get();
        $desa = Wilayah::where('parent', $kec_id)->orderBy('name', 'asc')->get();

        $users = User::with('jabatan', 'jenis', 'organisasi', 'wilayah', 'region', 'sub_region')->get();
        $korlap = Korlap::with(['user', 'user.organisasi'])->get();
        $regions = Region::get();
        $sub_regions = SubRegion::where('region_id', $region_id)->get();

        $organisasi = Organisasi::all();
        return inertia('/data/korlap/create', [
            'prov' => $prov,
            'kab' => $kab,
            'kec' => $kec,
            'desa' => $desa,

            'users' => $users,
            'regions' => $regions,
            'sub_regions' => $sub_regions,
            'korlaps' => $korlap,
            'organisasis' => $organisasi,
            'title' => 'Pangadaan Order Pembelian'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = [
                'no' => $request->input('no'),
                'nik' => $request->input('nik'),
                'nama' => $request->input('nama'),
                'user_id' => $request->input('user_id'),
                'organisasi_id' => $request->input('organisasi_id'),
            ];

            $no_organisasi = Organisasi::where('id', $data['organisasi_id'])->value('no');

            $user = User::findOrFail($data['user_id']);

            $data['no'] = IdGenerator::generate([
                'table' => 'korlaps',
                'field' => 'no',
                'length' => 14,
                'reset_on_prefix_change' => true,
                'prefix' => $no_organisasi . "."
            ]);

            // $data['desa_id'] = Wilayah::where('code', $request->input('desa'))->value('id');

            Korlap::create($data);
            return redirect()
                ->route('korlap.index')
                ->with('success', 'data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()
                ->route('korlap.index')
                ->with('error', 'data gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Korlap  $korlap
     * @return \Illuminate\Http\Response
     */
    public function show(Korlap $korlap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Korlap  $korlap
     * @return \Illuminate\Http\Response
     */
    public function edit(Korlap $korlap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Korlap  $korlap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Korlap $korlap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Korlap  $korlap
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $korlap = Korlap::findOrFail($id);

            $user_id = $korlap->user_id;
            $isdeleted = $korlap->delete();

            if ($isdeleted) {
                User::destroy($user_id);
            }

            return redirect()
                ->route('korlap.index')
                ->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('korlap.index')->with('error', 'Tidak dapat menghapus data');
        }
    }
}
