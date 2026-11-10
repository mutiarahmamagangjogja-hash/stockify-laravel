<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Carbon\Carbon;

class ManagerGudangController extends Controller
{
    /**
     * ============================================================
     * DASHBOARD MANAGER GUDANG
     * ============================================================
     */
    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | CARD 1 - STOK MENIPIS
        |--------------------------------------------------------------------------
        */

        $stokMenipis = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CARD 2 - BARANG MASUK HARI INI
        |--------------------------------------------------------------------------
        */

        $barangMasukHariIni = StockTransaction::where(
            'type',
            'in'
        )
        ->whereDate(
            'created_at',
            Carbon::today()
        )
        ->sum('quantity');


        /*
        |--------------------------------------------------------------------------
        | CARD 3 - BARANG KELUAR HARI INI
        |--------------------------------------------------------------------------
        */

        $barangKeluarHariIni = StockTransaction::where(
            'type',
            'out'
        )
        ->whereDate(
            'created_at',
            Carbon::today()
        )
        ->sum('quantity');


        /*
        |--------------------------------------------------------------------------
        | CARD 4 - TOTAL STOK
        |--------------------------------------------------------------------------
        */

        $totalStok = Product::sum('stock');


        /*
        |--------------------------------------------------------------------------
        | FILTER GRAFIK
        |--------------------------------------------------------------------------
        |
        | Default = 7 hari
        |
        */

        $period = request()->get(
            'period',
            '7'
        );


        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK
        |--------------------------------------------------------------------------
        */

        $chartLabels = [];
        $chartMasuk = [];
        $chartKeluar = [];


        /*
        |--------------------------------------------------------------------------
        | 7 HARI
        |--------------------------------------------------------------------------
        */

        if ($period === '7') {

            for ($i = 6; $i >= 0; $i--) {

                $date = Carbon::today()->subDays($i);


                $chartLabels[] =
                    $date->format('d M');


                $chartMasuk[] =
                    StockTransaction::where(
                        'type',
                        'in'
                    )
                    ->whereDate(
                        'created_at',
                        $date
                    )
                    ->sum('quantity');


                $chartKeluar[] =
                    StockTransaction::where(
                        'type',
                        'out'
                    )
                    ->whereDate(
                        'created_at',
                        $date
                    )
                    ->sum('quantity');
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 30 HARI
        |--------------------------------------------------------------------------
        */

        elseif ($period === '30') {

            for ($i = 29; $i >= 0; $i--) {

                $date =
                    Carbon::today()->subDays($i);


                $chartLabels[] =
                    $date->format('d M');


                $chartMasuk[] =
                    StockTransaction::where(
                        'type',
                        'in'
                    )
                    ->whereDate(
                        'created_at',
                        $date
                    )
                    ->sum('quantity');


                $chartKeluar[] =
                    StockTransaction::where(
                        'type',
                        'out'
                    )
                    ->whereDate(
                        'created_at',
                        $date
                    )
                    ->sum('quantity');
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 12 BULAN
        |--------------------------------------------------------------------------
        */

        elseif ($period === '12') {

            for ($i = 11; $i >= 0; $i--) {

                $date =
                    Carbon::now()
                        ->subMonths($i);


                $year =
                    $date->year;


                $month =
                    $date->month;


                $chartLabels[] =
                    $date->format('M Y');


                $chartMasuk[] =
                    StockTransaction::where(
                        'type',
                        'in'
                    )
                    ->whereYear(
                        'created_at',
                        $year
                    )
                    ->whereMonth(
                        'created_at',
                        $month
                    )
                    ->sum('quantity');


                $chartKeluar[] =
                    StockTransaction::where(
                        'type',
                        'out'
                    )
                    ->whereYear(
                        'created_at',
                        $year
                    )
                    ->whereMonth(
                        'created_at',
                        $month
                    )
                    ->sum('quantity');
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'manager-gudang.dashboard',
            compact(
                'stokMenipis',
                'barangMasukHariIni',
                'barangKeluarHariIni',
                'totalStok',
                'chartLabels',
                'chartMasuk',
                'chartKeluar',
                'period'
            )
        );
    }
}