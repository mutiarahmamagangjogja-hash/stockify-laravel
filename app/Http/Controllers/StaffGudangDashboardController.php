<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class StaffGudangDashboardController extends Controller
{
    /**
     * Dashboard Staff Gudang
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL STOK
        |--------------------------------------------------------------------------
        */

        $totalStock = Product::sum('stock');


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK YANG PERLU DIPERIKSA
        |--------------------------------------------------------------------------
        */

        $incomingPending = StockTransaction::where('type', 'in')
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'menunggu');
            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | BARANG KELUAR YANG PERLU DISIAPKAN
        |--------------------------------------------------------------------------
        */

        $outgoingPending = StockTransaction::where('type', 'out')
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'menunggu');
            })
            ->count();


        /*
        |--------------------------------------------------------------------------
        | STOCK OPNAME
        |--------------------------------------------------------------------------
        */

        $stockOpnamePending = 0;

        try {

            $stockOpnamePending = StockTransaction::where(
                'type',
                'opname'
            )
                ->where(function ($query) {
                    $query->where('status', 'pending')
                        ->orWhere('status', 'menunggu');
                })
                ->count();

        } catch (\Throwable $e) {

            $stockOpnamePending = 0;

        }


        /*
        |--------------------------------------------------------------------------
        | TUGAS YANG PERLU DISELESAIKAN
        |--------------------------------------------------------------------------
        */

        $tasks = collect();


        /*
        |--------------------------------------------------------------------------
        | TUGAS BARANG MASUK
        |--------------------------------------------------------------------------
        */

        $incomingTasks = StockTransaction::with('product')
            ->where('type', 'in')
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'menunggu');
            })
            ->latest()
            ->limit(5)
            ->get();


        foreach ($incomingTasks as $transaction) {

            $tasks->push([
                'type' => 'incoming',

                'title' => 'Periksa barang masuk',

                'description' =>
                    ($transaction->product->name ?? 'Produk')
                    . ' - '
                    . $transaction->quantity
                    . ' '
                    . ($transaction->product->unit ?? 'unit'),

                'date' => $transaction->created_at,

                /*
                |--------------------------------------------------------------
                | PENTING:
                | Jangan gunakan route stok.masuk karena itu route ADMIN.
                |--------------------------------------------------------------
                */

                'route' =>
                    route('staff-gudang.stok.masuk'),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | TUGAS BARANG KELUAR
        |--------------------------------------------------------------------------
        */

        $outgoingTasks = StockTransaction::with('product')
            ->where('type', 'out')
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'menunggu');
            })
            ->latest()
            ->limit(5)
            ->get();


        foreach ($outgoingTasks as $transaction) {

            $tasks->push([
                'type' => 'outgoing',

                'title' => 'Siapkan barang keluar',

                'description' =>
                    ($transaction->product->name ?? 'Produk')
                    . ' - '
                    . $transaction->quantity
                    . ' '
                    . ($transaction->product->unit ?? 'unit'),

                'date' => $transaction->created_at,

                /*
                |--------------------------------------------------------------
                | Route STAFF GUDANG
                |--------------------------------------------------------------
                */

                'route' =>
                    route('staff-gudang.stok.keluar'),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS STOK TERAKHIR
        |--------------------------------------------------------------------------
        |
        | Aktivitas diambil langsung dari StockTransaction.
        |
        | Jadi ketika transaksi baru dibuat, aktivitas akan ikut berubah.
        |
        */

        $recentTransactions = StockTransaction::with('product')
            ->whereIn('type', ['in', 'out'])
            ->latest()
            ->limit(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS
        |--------------------------------------------------------------------------
        */

        $activities = collect();


        foreach ($recentTransactions as $transaction) {

            $productName =
                $transaction->product->name
                ?? 'Produk';


            $unit =
                $transaction->product->unit
                ?? 'unit';


            /*
            |--------------------------------------------------------------------------
            | BARANG MASUK
            |--------------------------------------------------------------------------
            */

            if ($transaction->type === 'in') {

                if ($transaction->status === 'confirmed') {

                    $action = 'mengonfirmasi barang masuk';

                } elseif ($transaction->status === 'rejected') {

                    $action = 'menolak barang masuk';

                } else {

                    $action = 'mencatat barang masuk';

                }


                $description =
                    $productName
                    . ' sebanyak '
                    . $transaction->quantity
                    . ' '
                    . $unit;
            }


            /*
            |--------------------------------------------------------------------------
            | BARANG KELUAR
            |--------------------------------------------------------------------------
            */

            else {

                if ($transaction->status === 'confirmed') {

                    $action = 'mengonfirmasi barang keluar';

                } elseif ($transaction->status === 'rejected') {

                    $action = 'menolak barang keluar';

                } else {

                    $action = 'mencatat barang keluar';

                }


                $description =
                    $productName
                    . ' sebanyak '
                    . $transaction->quantity
                    . ' '
                    . $unit;
            }


            $activities->push([
                'name' => 'Staff Gudang',

                'action' => $action,

                'description' => $description,

                'created_at' => $transaction->created_at,

                'type' => $transaction->type,

                'status' => $transaction->status,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA BELUM ADA TRANSAKSI
        |--------------------------------------------------------------------------
        |
        | Ambil ActivityLog sebagai fallback.
        |
        */

        if ($activities->isEmpty()) {

            try {

                $logs = ActivityLog::with('user')
                    ->latest()
                    ->limit(6)
                    ->get();


                foreach ($logs as $log) {

                    $activities->push([
                        'name' =>
                            $log->user->name
                            ?? 'Staff Gudang',

                        'action' =>
                            $log->action,

                        'description' =>
                            $log->description,

                        'created_at' =>
                            $log->created_at,

                        'type' => null,

                        'status' => null,
                    ]);
                }

            } catch (\Throwable $e) {

                // Tidak melakukan apa-apa.
                // Dashboard tetap berjalan jika ActivityLog bermasalah.

            }
        }


        /*
        |--------------------------------------------------------------------------
        | RINGKASAN STOK HARI INI
        |--------------------------------------------------------------------------
        */

        $todayIncoming = StockTransaction::where(
            'type',
            'in'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->where(
                'status',
                'confirmed'
            )
            ->sum('quantity');


        $todayOutgoing = StockTransaction::where(
            'type',
            'out'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->where(
                'status',
                'confirmed'
            )
            ->sum('quantity');


        /*
        |--------------------------------------------------------------------------
        | JUMLAH TRANSAKSI HARI INI
        |--------------------------------------------------------------------------
        */

        $todayIncomingTransactions = StockTransaction::where(
            'type',
            'in'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->where(
                'status',
                'confirmed'
            )
            ->count();


        $todayOutgoingTransactions = StockTransaction::where(
            'type',
            'out'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->where(
                'status',
                'confirmed'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'staff-gudang.dashboard',
            [

                'incomingPending' =>
                    $incomingPending,

                'outgoingPending' =>
                    $outgoingPending,

                'totalStock' =>
                    $totalStock,

                'stockOpnamePending' =>
                    $stockOpnamePending,

                'tasks' =>
                    $tasks
                        ->sortByDesc('date')
                        ->take(6),

                'activities' =>
                    $activities
                        ->sortByDesc('created_at')
                        ->take(6),

                'todayIncoming' =>
                    $todayIncoming,

                'todayOutgoing' =>
                    $todayOutgoing,

                'todayIncomingTransactions' =>
                    $todayIncomingTransactions,

                'todayOutgoingTransactions' =>
                    $todayOutgoingTransactions,

            ]
        );
    }
}