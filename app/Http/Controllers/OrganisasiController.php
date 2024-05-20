<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\SubRegion;
use App\Models\Organisasi;
use App\Utils\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $organisasi_id = $request->input(('organisasi_id'));

        $organisasi = Organisasi::with((['sub_region', 'wilayah']))
            ->when($organisasi_id, function ($query, $organisasi_id) {
                return $query->where('id',  "$organisasi_id");
            })
            ->get();
        $subregions = SubRegion::all();
        return inertia('data/organisasi.index', [
            'organisasis' => $organisasi,
            'subregion' => $subregions,
            'title' => 'Data Organisasi'
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

        $subregions = SubRegion::all();
        return inertia('data/organisasi/create', [
            'prov' => $prov,
            'kab' => $kab,
            'kec' => $kec,
            'desa' => $desa,

            'subregions' => $subregions,
            'title' => 'Buat Data Organisasi',
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
        $data = [
            'sub_region_id' => $request->input('sub_region_id'),
            'nama_organisasi' => $request->input('nama_organisasi'),
            'alamat_organisasi' => $request->input('alamat_organisasi'),
            'provinsi' => $request->input('provinsi'),
            'kabupaten' => $request->input('kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'desa' => $request->input('desa'),
        ];

        $subregion = SubRegion::find($data['sub_region_id']);

        $data['no'] = IdGenerator::generate([
            'table' => 'organisasis',
            'field' => 'no',
            'length' => 8,
            'reset_on_prefix_change' => true,
            'prefix' => $subregion->no . "."
        ]);
        // dd($data);
        Organisasi::create($data);

        return redirect()
            ->route('organisasi.index')
            ->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function show(Organisasi $organisasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // mengambil wilayah
        $prov_id = $request->input('prov_id');
        $kab_id = $request->input('kab_id');
        $kec_id = $request->input('kec_id');

        $prov = Wilayah::where('parent', 0)->orderBy('name', 'asc')->get();
        $kab = Wilayah::where('parent', $prov_id)->orderBy('name', 'asc')->get();
        $kec = Wilayah::where('parent', $kab_id)->orderBy('name', 'asc')->get();
        $desa = Wilayah::where('parent', $kec_id)->orderBy('name', 'asc')->get();

        $organisasi = Organisasi::findOrFail($id);
        $organisasi->load(['sub_region', 'wilayah']);
        $subregions = SubRegion::all();
        return inertia('data/organisasi/edit', [
            'prov' => $prov,
            'kab' => $kab,
            'kec' => $kec,
            'desa' => $desa,

            'subregions' => $subregions,
            'organisasi' => $organisasi,
            'title' => 'Edit Data Organisasi',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organisasi = Organisasi::findOrFail($id);
        $data = [
            'sub_region_id' => $request->input('sub_region_id'),
            'nama_organisasi' => $request->input('nama_organisasi'),
            'alamat_organisasi' => $request->input('alamat_organisasi'),
            'provinsi' => $request->input('provinsi'),
            'kabupaten' => $request->input('kabupaten'),
            'kecamatan' => $request->input('kecamatan'),
            'desa' => $request->input('desa'),
        ];

        $organisasi->update($data);
        // dd($data);
        return redirect()
            ->route('organisasi.index', [
                'organisasi' => $organisasi->id,
            ])
            ->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organisasi  $organisasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisasi $organisasi)
    {
        $organisasi->delete();
        return redirect()
            ->route('organisasi.index')
            ->with('success', 'data berhasil dihapus');
    }
}
