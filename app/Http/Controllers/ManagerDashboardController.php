<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        return view('manager.dashboard', [

            'totalStok' => 116,

            'barangMasukHariIni' => 12,

            'barangKeluarHariIni' => 5,

            'stokMenipis' => 2,

            'chartLabels' => [
                'Sen',
                'Sel',
                'Rab',
                'Kam',
                'Jum',
                'Sab',
                'Min'
            ],

            'chartMasuk' => [
                25,
                40,
                30,
                55,
                42,
                60,
                48
            ],

            'chartKeluar' => [
                10,
                20,
                15,
                30,
                25,
                35,
                28
            ]

        ]);
    }
}
