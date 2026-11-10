<?php

namespace App\Http\Controllers;

use App\Models\StockOpname;

class StockOpnameController extends Controller
{


    /**
     * ============================================================
     * DAFTAR STOCK OPNAME ADMIN
     * ============================================================
     */
    public function index()
    {
     
        

        $opnames = StockOpname::with([
            'product',
            'user',
        ])
            ->latest()
            ->get();


       

        return view(
            'stock.opname',
            [
                'opnames' => $opnames,
            ]
        );
    }


    /**
     * ============================================================
     * DETAIL STOCK OPNAME ADMIN
     * ============================================================
     */
    public function show(StockOpname $opname)
    {
        /*
        |--------------------------------------------------------------------------
        | Load relasi
        |--------------------------------------------------------------------------
        */

        $opname->load([
            'product',
            'user',
        ]);


       
        return view(
            'stock.opname-detail',
            [
                'opname' => $opname,
            ]
        );
    }
}
