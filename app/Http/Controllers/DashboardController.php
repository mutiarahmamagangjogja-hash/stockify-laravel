<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\StockTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * ============================================================
     * DASHBOARD ADMIN
     * ============================================================
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS PENGGUNA
        |--------------------------------------------------------------------------
        */

        $activities = ActivityLog::with('user')
            ->latest()
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | PRODUK STOK RENDAH
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = Product::with('category')
            ->whereColumn(
                'stock',
                '<=',
                'minimum_stock'
            )
            ->orderBy(
                'stock',
                'asc'
            )
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL PRODUK
        |--------------------------------------------------------------------------
        */

        $totalProduk = Product::count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL STOK BARANG SAAT INI
        |--------------------------------------------------------------------------
        |
        | Ini adalah stok aktual yang tersimpan di tabel products.
        |
        */

        $totalStok = Product::sum('stock');


        /*
        |--------------------------------------------------------------------------
        | STOK MENIPIS
        |--------------------------------------------------------------------------
        */

        $stokMenipis = Product::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL TRANSAKSI STOK MASUK
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | Card ini menghitung SELURUH transaksi barang masuk
        | berdasarkan tabel stock_transactions.
        |
        | Tidak menggunakan Product::stock.
        |
        */

        $totalStokMasuk = StockTransaction::where(
            'type',
            'in'
        )->sum('quantity');


        /*
        |--------------------------------------------------------------------------
        | TOTAL TRANSAKSI STOK KELUAR
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | Card ini menghitung SELURUH transaksi barang keluar
        | berdasarkan tabel stock_transactions.
        |
        */

        $totalStokKeluar = StockTransaction::where(
            'type',
            'out'
        )->sum('quantity');


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK HARI INI
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
        | BARANG KELUAR HARI INI
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
        | GRAFIK 7 HARI
        |--------------------------------------------------------------------------
        |
        | QUERY SAMA PERSIS DENGAN MANAGER GUDANG.
        |
        */

        $chart7Labels = [];

        $chart7Masuk = [];

        $chart7Keluar = [];


        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()
                ->subDays($i);


            $chart7Labels[] =
                $date->format('d M');


            $chart7Masuk[] =
                StockTransaction::where(
                    'type',
                    'in'
                )
                ->whereDate(
                    'created_at',
                    $date
                )
                ->sum('quantity');


            $chart7Keluar[] =
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


        /*
        |--------------------------------------------------------------------------
        | GRAFIK 30 HARI
        |--------------------------------------------------------------------------
        |
        | QUERY SAMA DENGAN MANAGER.
        |
        */

        $chart30Labels = [];

        $chart30Masuk = [];

        $chart30Keluar = [];


        for ($i = 29; $i >= 0; $i--) {

            $date = Carbon::today()
                ->subDays($i);


            $chart30Labels[] =
                $date->format('d M');


            $chart30Masuk[] =
                StockTransaction::where(
                    'type',
                    'in'
                )
                ->whereDate(
                    'created_at',
                    $date
                )
                ->sum('quantity');


            $chart30Keluar[] =
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


        /*
        |--------------------------------------------------------------------------
        | GRAFIK 12 BULAN
        |--------------------------------------------------------------------------
        |
        | QUERY SAMA DENGAN MANAGER.
        |
        */

        $chart12Labels = [];

        $chart12Masuk = [];

        $chart12Keluar = [];


        for ($i = 11; $i >= 0; $i--) {

            $date = Carbon::now()
                ->startOfMonth()
                ->subMonths($i);


            $chart12Labels[] =
                $date->format('M Y');


            $chart12Masuk[] =
                StockTransaction::where(
                    'type',
                    'in'
                )
                ->whereYear(
                    'created_at',
                    $date->year
                )
                ->whereMonth(
                    'created_at',
                    $date->month
                )
                ->sum('quantity');


            $chart12Keluar[] =
                StockTransaction::where(
                    'type',
                    'out'
                )
                ->whereYear(
                    'created_at',
                    $date->year
                )
                ->whereMonth(
                    'created_at',
                    $date->month
                )
                ->sum('quantity');
        }


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE DASHBOARD ADMIN
        |--------------------------------------------------------------------------
        */

        return view(
            'welcome',
            compact(

                /*
                | Aktivitas
                */
                'activities',


                /*
                | Produk
                */
                'lowStockProducts',
                'totalProduk',


                /*
                | Stok
                */
                'totalStok',
                'stokMenipis',


                /*
                | Total transaksi
                */
                'totalStokMasuk',
                'totalStokKeluar',


                /*
                | Hari ini
                */
                'barangMasukHariIni',
                'barangKeluarHariIni',


                /*
                | Grafik 7 hari
                */
                'chart7Labels',
                'chart7Masuk',
                'chart7Keluar',


                /*
                | Grafik 30 hari
                */
                'chart30Labels',
                'chart30Masuk',
                'chart30Keluar',


                /*
                | Grafik 12 bulan
                */
                'chart12Labels',
                'chart12Masuk',
                'chart12Keluar'
            )
        );
    }
}