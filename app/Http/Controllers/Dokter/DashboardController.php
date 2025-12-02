<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Controller Dokter memuat view dokter.dashboard
        return view('dokter.dashboard'); 
    }
}