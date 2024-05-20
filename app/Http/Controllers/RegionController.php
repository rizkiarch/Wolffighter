<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Organisasi;
use App\Utils\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $region = Region::with('sub_region')->when($search, function ($query, $search) {
            return $query->where('name_region', 'like', "%$search%");
        })->get();
        return inertia('data/region.index', [
            'region' => $region,
            'title' => 'Data Region'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('data/region/create', [
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
        $data = $request->validate([
            'name_region' => 'required',
        ]);

        $data['no'] = IdGenerator::generate([
            'table' => 'regions',
            'field' => 'no',
            'length' => 2,
            'reset_on_prefix_change' => true,
            // 'prefix' => null
        ]);
        // dd($data);
        Region::create($data);
        return redirect()
            ->route('region.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        return inertia('data/region/edit', [
            'region' => $region,
            'title' => 'Edit Data Organisasi',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $data = $request->validate([
            'name_region' => 'required',
        ]);

        $region->update($data);
        return redirect()
            ->route('region.index')
            ->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()
            ->route('region.index')
            ->with('success', 'Data Berhasil Dihapus');
    }
}
