<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jenis;
use App\Models\Korlap;
use App\Models\Jabatan;
use App\Models\KorlapDetail;
use App\Models\Wilayah;
use App\Models\Organisasi;
use App\Models\Region;
use App\Models\SubRegion;
use App\Utils\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenis_id = $request->input('jenis_id');


        $user = User::with(([
            'jabatan',
            'jenis',
            'organisasi',
            'wilayah'
        ]))
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%");
            })
            ->when($jenis_id, function ($query, $jenis_id) {
                return $query->where('jenis_id',  "$jenis_id");
            })->get();

        $jenis = Jenis::all();
        return inertia('data/relawan.index', [
            'users' => $user,
            'jenis' => $jenis,
            'title' => 'Data Relawan'
        ]);
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

        $prov = Wilayah::where('parent', 0)->orderBy('name', 'asc')->get();
        $kab = Wilayah::where('parent', $prov_id)->orderBy('name', 'asc')->get();
        $kec = Wilayah::where('parent', $kab_id)->orderBy('name', 'asc')->get();
        $desa = Wilayah::where('parent', $kec_id)->orderBy('name', 'asc')->get();

        $region_id = $request->input('region_id');

        $regions = Region::all();
        $organisasi = Organisasi::all();
        $jenis = Jenis::all();
        $jabatan = Jabatan::all();
        $subregions = SubRegion::where('region_id', $region_id)->get();

        $korlaps = Korlap::all();
        // $korlap = Korlap::all();
        return inertia('data/relawan/create', [
            'prov' => $prov,
            'kab' => $kab,
            'kec' => $kec,
            'desa' => $desa,
            'korlaps' => $korlaps,

            'regions' => $regions,
            'subregions' => $subregions,
            'organisasis' => $organisasi,
            'jenis' => $jenis,
            'jabatan' => $jabatan,
            'title' => 'Buat Data Region',
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
            $jenis_id = $request->input('jenis_id');
            $korlap_id = $request->input('korlap_id');

            $data = [
                'nik' => $request->input('nik'),
                'name' => $request->input('name'),
                'jk' => $request->input('jk'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),

                'provinsi' => $request->input('provinsi'),
                'kabupaten' => $request->input('kabupaten'),
                'kecamatan' => $request->input('kecamatan'),
                'desa' => $request->input('desa'),
                'rt' => $request->input('rt'),
                'rw' => $request->input('rw'),


                'jabatan_id' => $request->input('jabatan_id'),
                'jenis_id' => $request->input('jenis_id'),
                'organisasi_id' => $request->input('organisasi_id'),
                'region_id' => $request->input('region_id'),
                'sub_region_id' => $request->input('sub_region_id'),


            ];

            $organisasi = Organisasi::find($data['organisasi_id']);

            $data['no'] = IdGenerator::generate([
                'table' => 'users',
                'field' => 'no',
                'length' => 14,
                'reset_on_prefix_change' => true,
                'prefix' => $organisasi->no . "."
            ]);

            $data['desa_id'] = Wilayah::where('code', $data['desa'])->value('id');

            $user = User::create($data);

            if ($jenis_id == 2) {
                $data_korlap = [
                    'nik' => $data['nik'],
                    'nama' => $user->name,
                    'user_id' => $user->id,
                    'organisasi_id' => $data['organisasi_id'],
                ];

                $data_korlap['no'] = IdGenerator::generate([
                    'table' => 'korlaps',
                    'field' => 'no',
                    'length' => 13,
                    'reset_on_prefix_change' => true,
                    'prefix' => $organisasi->no . "."
                ]);

                Korlap::create($data_korlap);
            } else {
                KorlapDetail::firstOrCreate([
                    'user_id' => $user->id,
                    'korlap_id' => $korlap_id,
                ]);
            }

            \DB::commit();
            return redirect()->route('relawan.index')->with('success', 'Data Berhasil Ditambahkan');
        } catch (\Throwable $e) {
            \DB::rollBack();
            return redirect()->route('relawan.index')->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $users->load(['jenis', 'jabatan', 'organisasi', 'region', 'sub_region']);

        // wilayah
        $prov_id = $request->input('prov_id');
        $kab_id = $request->input('kab_id');
        $kec_id = $request->input('kec_id');

        $prov = Wilayah::where('parent', 0)->orderBy('name', 'asc')->get();
        $kab = Wilayah::where('parent', $prov_id)->orderBy('name', 'asc')->get();
        $kec = Wilayah::where('parent', $kab_id)->orderBy('name', 'asc')->get();
        $desa = Wilayah::where('parent', $kec_id)->orderBy('name', 'asc')->get();

        $region = Region::all();
        $subregion = SubRegion::all();
        $organisasi = Organisasi::all();
        $jenis = Jenis::all();
        $jabatan = Jabatan::all();
        return inertia('data/relawan/edit', [
            'prov' => $prov,
            'kab' => $kab,
            'kec' => $kec,
            'desa' => $desa,

            'regions' => $region,
            'subregions' => $subregion,
            'organisasis' => $organisasi,
            'jenis' => $jenis,
            'jabatan' => $jabatan,
            'users' => $users,
            'title' => 'Edit Data Organisasi',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = [
            'nik' => $request->input('nik'),
            'name' => $request->input('name'),
            'jk' => $request->input('jk'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),

            'provinsi' => $request->input('provinsi'),
            'kabupaten' => $request->input('kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'desa' => $request->input('desa'),
            'rt' => $request->input('rt'),
            'rw' => $request->input('rw'),


            'jabatan_id' => $request->input('jabatan_id'),
            'jenis_id' => $request->input('jenis_id'),
            'organisasi_id' => $request->input('organisasi_id'),
            'region_id' => $request->input('region_id'),
            'sub_region_id' => $request->input('sub_region_id'),
        ];

        $user->update($data);
        dd($data);
        return redirect()
            ->route('relawan.index')
            ->with('success', 'data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::destroy($id);
            // dd($user);
            return redirect()
                ->route('relawan.index')
                ->with('success', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('relawan.index')->with('error', 'Tidak dapat menghapus data');
        }
    }
}
