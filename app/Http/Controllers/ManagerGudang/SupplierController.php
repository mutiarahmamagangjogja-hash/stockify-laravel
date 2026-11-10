<?php

namespace App\Http\Controllers\ManagerGudang;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier untuk Manager Gudang
     */
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view(
            'manager-gudang.supplier.index',
            compact('suppliers')
        );
    }
}