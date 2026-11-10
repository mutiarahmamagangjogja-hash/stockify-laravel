<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
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
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();


        $stockIn = $transactions
            ->where('type', 'in')
            ->sum('quantity');


        $stockOut = $transactions
            ->where('type', 'out')
            ->sum('quantity');


        $totalProducts = Product::count();


        $lowStock = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();


        $totalStock = Product::sum('stock');


        return view(
            'report.index',
            compact(
                'transactions',
                'stockIn',
                'stockOut',
                'totalProducts',
                'lowStock',
                'totalStock',
                'startDate',
                'endDate'
            )
        );
    }
}