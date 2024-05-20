<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\SubRegion;
use App\Utils\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SubRegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $region_id = $request->input('region_id');
        $subregion = SubRegion::with(([
            'region'
        ]))
            ->when($search, function ($query, $search) {
                return $query->where('name_sub_region', 'like', "%$search%");
            })
            ->when($region_id, function ($query, $region_id) {
                return $query->where('region_id',  "$region_id");
            })->get();
        $regions = Region::all();
        return inertia('data/sub-region/index', [
            'regions' => $regions,
            'subregions' => $subregion,
            'title' => 'Data sub region'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regions = Region::all();
        return inertia('data/sub-region/create', [
            'regions' => $regions,
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
        $data = [
            'name_sub_region' => $request->input('name_sub_region'),
            'region_id' => $request->input('region_id'),
        ];

        $region = Region::find($data['region_id']);

        $data['no'] = IdGenerator::generate([
            'table' => 'sub_regions',
            'field' => 'no',
            'length' => 5,
            'reset_on_prefix_change' => true,
            'prefix' => $region->no . "."
        ]);
        // dd($data);
        SubRegion::create($data);
        return redirect()
            ->route('sub-region.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubRegion  $subRegion
     * @return \Illuminate\Http\Response
     */
    public function show(SubRegion $subRegion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubRegion  $subRegion
     * @return \Illuminate\Http\Response
     */
    public function edit(SubRegion $subRegion)
    {

        $regions = Region::all();
        return inertia('data/sub-region/edit', [
            'regions' => $regions,
            'subregion' => $subRegion,
            'title' => 'Edit Data Organisasi',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubRegion  $subRegion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubRegion $subRegion)
    {
        $data = [
            'name_sub_region' => $request->input('name_sub_region'),
            'region_id' => $request->input('region_id'),
        ];

        $subRegion->update($data);
        return redirect()
            ->route('sub-region.index')
            ->with('success', 'Data Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubRegion  $subRegion
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubRegion $subRegion)
    {
        $subRegion->delete();
        // dd($subRegion);
        return redirect()
            ->route('sub-region.index')
            ->with('success', 'Data Berhasil Dihapus');
    }
}
