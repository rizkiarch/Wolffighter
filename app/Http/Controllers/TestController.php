<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $region = '10';
        $sub_region = $region . '01';
        $organisasi = $sub_region . '01';
        $korlap = $organisasi . '001';

        dd($korlap);
    }
}
