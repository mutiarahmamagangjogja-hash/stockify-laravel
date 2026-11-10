<?php

namespace App\Http\Controllers\ManagerGudang;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * ============================================================
     * LAPORAN STOK
     * ============================================================
     */
    public function stok()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->get();

        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');

        $lowStock = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();

        return view(
            'manager-gudang.laporan.stok',
            compact(
                'products',
                'totalProducts',
                'totalStock',
                'lowStock'
            )
        );
    }


    /**
     * ============================================================
     * LAPORAN BARANG MASUK & KELUAR
     * ============================================================
     */
    public function transaksi(Request $request)
    {
        $startDate = $request->input(
            'start_date',
            now()->startOfMonth()->format('Y-m-d')
        );

        $endDate = $request->input(
            'end_date',
            now()->format('Y-m-d')
        );


        $transactions = StockTransaction::with('product')
            ->whereDate(
                'created_at',
                '>=',
                $startDate
            )
            ->whereDate(
                'created_at',
                '<=',
                $endDate
            )
            ->latest()
            ->get();


        $stockIn = $transactions
            ->where('type', 'in')
            ->sum('quantity');


        $stockOut = $transactions
            ->where('type', 'out')
            ->sum('quantity');


        return view(
            'manager-gudang.laporan.transaksi',
            compact(
                'transactions',
                'stockIn',
                'stockOut',
                'startDate',
                'endDate'
            )
        );
    }
}