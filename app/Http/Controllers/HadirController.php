<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use Illuminate\Http\Request;

class HadirController extends Controller
{
    public function index()
    {
        $query = Kehadiran::with([
            'user',
            'user.region',
            'user.wilayah',
            'user.jabatan',
            'user.organisasi'
        ]);

        $data = $query->get();

        return inertia('peserta/hadir/index', [
            'data' => $data
        ]);
    }

    public function scan(Request $request)
    {
        $user_id = $request->input('user_id');

        $user = Kehadiran::where('user_id', $user_id)
            ->whereDate('check_in', now());

        if (!$user->exists()) {
            Kehadiran::create([
                'check_in' => now(),
                'user_id' => $user_id,
            ]);
        } else {
            return redirect()
                ->route('hadir.index')
                ->with('error', 'Peserta sudah hadir');
        }

        return redirect()
            ->route('hadir.index')
            ->with('success', 'Peserta berhasil hadir');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
