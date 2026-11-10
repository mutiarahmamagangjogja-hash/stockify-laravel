<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| CONTROLLERS - ADMIN
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductImportExportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMinimumController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;


/*
|--------------------------------------------------------------------------
| CONTROLLERS - MANAGER GUDANG
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ManagerGudangController;
use App\Http\Controllers\ManagerGudangProductController;
use App\Http\Controllers\ManagerGudang\StockInController;
use App\Http\Controllers\ManagerGudang\StockOutController;
use App\Http\Controllers\ManagerGudang\StockOpnameController as ManagerStockOpnameController;
use App\Http\Controllers\ManagerGudang\SupplierController as ManagerGudangSupplierController;
use App\Http\Controllers\ManagerGudang\ReportController as ManagerGudangReportController;


/*
|--------------------------------------------------------------------------
| CONTROLLERS - STAFF GUDANG
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\StaffGudangDashboardController;
use App\Http\Controllers\StaffGudang\StaffGudangStockController;
use App\Http\Controllers\StaffGudang\StockOpnameController as StaffStockOpnameController;


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Semua user masuk melalui satu halaman login.
|
*/

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.process');

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Hanya user dengan role = admin.
|
*/

Route::middleware([
    'auth',
    'role:admin'
])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/',
        [DashboardController::class, 'index']
    )->name('dashboard');

    Route::get(
        '/dashboard/realtime',
        [DashboardController::class, 'realtime']
    )->name('dashboard.realtime');


    /*
    |--------------------------------------------------------------------------
    | PRODUK ADMIN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'produk',
        ProductController::class
    )->except([
        'show'
    ])->parameters([
        'produk' => 'product'
    ]);


    /*
    |--------------------------------------------------------------------------
    | KATEGORI ADMIN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'kategori',
        CategoryController::class
    )->except([
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | ATRIBUT PRODUK ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/atribut-produk',
        [ProductAttributeController::class, 'index']
    )->name('atribut.index');

    Route::post(
        '/atribut-produk',
        [ProductAttributeController::class, 'store']
    )->name('atribut.store');

    Route::put(
        '/atribut-produk/{attribute}',
        [ProductAttributeController::class, 'update']
    )->name('atribut.update');

    Route::delete(
        '/atribut-produk/{attribute}',
        [ProductAttributeController::class, 'destroy']
    )->name('atribut.destroy');

    Route::post(
        '/atribut-produk/{attribute}/nilai',
        [ProductAttributeController::class, 'storeValue']
    )->name('atribut.value.store');

    Route::delete(
        '/atribut-produk/nilai/{value}',
        [ProductAttributeController::class, 'destroyValue']
    )->name('atribut.value.destroy');


    /*
    |--------------------------------------------------------------------------
    | IMPORT / EXPORT PRODUK ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/produk-import-export',
        [ProductImportExportController::class, 'index']
    )->name('produk.import-export');

    Route::get(
        '/produk-export',
        [ProductImportExportController::class, 'export']
    )->name('produk.export');

    Route::post(
        '/produk-import',
        [ProductImportExportController::class, 'import']
    )->name('produk.import');

    Route::get(
        '/produk-import-template',
        [ProductImportExportController::class, 'template']
    )->name('produk.import.template');


    /*
    |--------------------------------------------------------------------------
    | STOK ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/stok/masuk',
        [StockController::class, 'in']
    )->name('stok.masuk');

    Route::post(
        '/stok/masuk',
        [StockController::class, 'storeIn']
    )->name('stok.masuk.store');

    Route::get(
        '/stok/keluar',
        [StockController::class, 'out']
    )->name('stok.keluar');

    Route::post(
        '/stok/keluar',
        [StockController::class, 'storeOut']
    )->name('stok.keluar.store');

    Route::get(
        '/stok/riwayat',
        [StockController::class, 'history']
    )->name('stok.riwayat');


    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME ADMIN
    |--------------------------------------------------------------------------
    |
    | Admin hanya dapat melihat.
    |
    */

    Route::get(
        '/stok/opname',
        [StockOpnameController::class, 'index']
    )->name('stok.opname');

    Route::get(
        '/stok/opname/{opname}',
        [StockOpnameController::class, 'show']
    )->name('stok.opname.detail');


    /*
    |--------------------------------------------------------------------------
    | STOK MINIMUM ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/stok/minimum',
        [StockMinimumController::class, 'index']
    )->name('stok.minimum');

    Route::put(
        '/stok/minimum/{product}',
        [StockMinimumController::class, 'update']
    )->name('stok.minimum.update');


    /*
    |--------------------------------------------------------------------------
    | SUPPLIER ADMIN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'supplier',
        SupplierController::class
    )->except([
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | PENGGUNA ADMIN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'pengguna',
        UserController::class
    )->except([
        'show'
    ]);


    /*
    |--------------------------------------------------------------------------
    | LAPORAN ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/laporan',
        [ReportController::class, 'index']
    )->name('laporan.index');


    /*
    |--------------------------------------------------------------------------
    | PENGATURAN ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengaturan',
        [SettingController::class, 'index']
    )->name('pengaturan.index');

    Route::put(
        '/pengaturan',
        [SettingController::class, 'update']
    )->name('pengaturan.update');

});


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| MANAGER GUDANG
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Hanya user dengan role = manager_gudang.
|
*/

Route::prefix('manager-gudang')
    ->name('manager-gudang.')
    ->middleware([
        'auth',
        'role:manager_gudang'
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [ManagerGudangController::class, 'dashboard']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PRODUK MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/produk',
            [ManagerGudangProductController::class, 'index']
        )->name('produk.index');

        Route::get(
            '/produk/tambah',
            [ManagerGudangProductController::class, 'create']
        )->name('produk.create');

        Route::post(
            '/produk',
            [ManagerGudangProductController::class, 'store']
        )->name('produk.store');

        Route::get(
            '/produk/{product}',
            [ManagerGudangProductController::class, 'show']
        )->name('produk.show');


        /*
        |--------------------------------------------------------------------------
        | STOK MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/stok',
            [ManagerGudangController::class, 'stok']
        )->name('stok');


        /*
        |--------------------------------------------------------------------------
        | STOCK OPNAME MANAGER
        |--------------------------------------------------------------------------
        |
        | Manager hanya dapat melihat.
        |
        */

        Route::get(
            '/stok/opname',
            [ManagerStockOpnameController::class, 'index']
        )->name('stok.opname');

        Route::get(
            '/stok/opname/{opname}',
            [ManagerStockOpnameController::class, 'show']
        )->name('stok.opname.detail');


        /*
        |--------------------------------------------------------------------------
        | BARANG MASUK MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/stok/masuk',
            [StockInController::class, 'index']
        )->name('stok.masuk');

        Route::get(
            '/stok/masuk/tambah',
            [StockInController::class, 'create']
        )->name('stok.masuk.create');

        Route::post(
            '/stok/masuk',
            [StockInController::class, 'store']
        )->name('stok.masuk.store');

        Route::get(
            '/stok/masuk/{id}',
            [StockInController::class, 'show']
        )->name('stok.masuk.show');


        /*
        |--------------------------------------------------------------------------
        | BARANG KELUAR MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/stok/keluar',
            [StockOutController::class, 'index']
        )->name('stok.keluar');

        Route::get(
            '/stok/keluar/tambah',
            [StockOutController::class, 'create']
        )->name('stok.keluar.create');

        Route::post(
            '/stok/keluar',
            [StockOutController::class, 'store']
        )->name('stok.keluar.store');

        Route::get(
            '/stok/keluar/{id}',
            [StockOutController::class, 'show']
        )->name('stok.keluar.show');


        /*
        |--------------------------------------------------------------------------
        | SUPPLIER MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/supplier',
            [ManagerGudangSupplierController::class, 'index']
        )->name('supplier.index');


        /*
        |--------------------------------------------------------------------------
        | LAPORAN MANAGER
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/laporan/stok',
            [ManagerGudangReportController::class, 'stok']
        )->name('laporan.stok');

        Route::get(
            '/laporan/transaksi',
            [ManagerGudangReportController::class, 'transaksi']
        )->name('laporan.transaksi');

    });


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| STAFF GUDANG
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Hanya user dengan role = staff_gudang.
|
*/

Route::prefix('staff-gudang')
    ->name('staff-gudang.')
    ->middleware([
        'auth',
        'role:staff_gudang'
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | DASHBOARD STAFF
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [
                StaffGudangDashboardController::class,
                'index'
            ]
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | STOK STAFF
        |--------------------------------------------------------------------------
        */

        Route::prefix('stok')
            ->name('stok.')
            ->group(function () {


                /*
                |--------------------------------------------------------------------------
                | BARANG MASUK STAFF
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/masuk',
                    [
                        StaffGudangStockController::class,
                        'masuk'
                    ]
                )->name('masuk');

                Route::get(
                    '/masuk/tambah',
                    [
                        StaffGudangStockController::class,
                        'tambahMasuk'
                    ]
                )->name('masuk.tambah');

                Route::post(
                    '/masuk',
                    [
                        StaffGudangStockController::class,
                        'simpanMasuk'
                    ]
                )->name('masuk.simpan');

                Route::patch(
                    '/masuk/{transaction}/konfirmasi',
                    [
                        StaffGudangStockController::class,
                        'konfirmasiMasuk'
                    ]
                )->name('masuk.konfirmasi');


                /*
                |--------------------------------------------------------------------------
                | BARANG KELUAR STAFF
                |--------------------------------------------------------------------------
                */

                Route::get(
                    '/keluar',
                    [
                        StaffGudangStockController::class,
                        'keluar'
                    ]
                )->name('keluar');

                Route::get(
                    '/keluar/tambah',
                    [
                        StaffGudangStockController::class,
                        'tambahKeluar'
                    ]
                )->name('keluar.tambah');

                Route::post(
                    '/keluar',
                    [
                        StaffGudangStockController::class,
                        'simpanKeluar'
                    ]
                )->name('keluar.simpan');

                Route::patch(
                    '/keluar/{transaction}/konfirmasi',
                    [
                        StaffGudangStockController::class,
                        'konfirmasiKeluar'
                    ]
                )->name('keluar.konfirmasi');


                /*
                |--------------------------------------------------------------------------
                | STOCK OPNAME STAFF
                |--------------------------------------------------------------------------
                |
                | Staff dapat melihat, membuat, dan menyimpan.
                |
                */

                Route::get(
                    '/opname',
                    [
                        StaffStockOpnameController::class,
                        'index'
                    ]
                )->name('opname');

                Route::get(
                    '/opname/tambah',
                    [
                        StaffStockOpnameController::class,
                        'create'
                    ]
                )->name('opname.tambah');

                Route::post(
                    '/opname',
                    [
                        StaffStockOpnameController::class,
                        'store'
                    ]
                )->name('opname.store');

                Route::get(
                    '/opname/{opname}',
                    [
                        StaffStockOpnameController::class,
                        'show'
                    ]
                )->name('opname.detail');

            });

    });