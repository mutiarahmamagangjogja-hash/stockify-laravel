<?php

namespace App\Http\Controllers\ManagerGudang;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;

class StockOpnameController extends Controller
{
    /**
     * Daftar Stock Opname
     *
     * Manager Gudang hanya dapat melihat
     * hasil stock opname yang dilakukan Staff Gudang.
     */
    public function index()
    {
        $opnames = StockOpname::with([
            'product',
            'user'
        ])
        ->latest()
        ->get();

        return view(
            'manager-gudang.stock.opname',
            compact('opnames')
        );
    }

    /**
     * Detail Stock Opname
     */
    public function show(StockOpname $opname)
    {
        $opname->load([
            'product',
            'user'
        ]);

        return view(
            'manager-gudang.stock.opname-detail',
            compact('opname')
        );
    }
}