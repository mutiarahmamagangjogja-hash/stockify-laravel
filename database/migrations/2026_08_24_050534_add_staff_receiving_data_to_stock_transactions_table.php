<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | TANGGAL PENERIMAAN
        |--------------------------------------------------------------------------
        |
        | Tambahkan hanya jika kolom belum ada.
        |
        */

        if (!Schema::hasColumn('stock_transactions', 'received_date')) {

            Schema::table('stock_transactions', function (Blueprint $table) {

                $table->date('received_date')
                    ->nullable();

            });

        }


        /*
        |--------------------------------------------------------------------------
        | SUMBER PRODUK
        |--------------------------------------------------------------------------
        |
        | existing = produk sudah terdaftar
        | new      = staff membuat produk baru
        |
        */

        if (!Schema::hasColumn('stock_transactions', 'product_source')) {

            Schema::table('stock_transactions', function (Blueprint $table) {

                $table->string('product_source')
                    ->default('existing');

            });

        }
    }


    public function down(): void
    {
        if (Schema::hasColumn('stock_transactions', 'received_date')) {

            Schema::table('stock_transactions', function (Blueprint $table) {

                $table->dropColumn('received_date');

            });

        }


        if (Schema::hasColumn('stock_transactions', 'product_source')) {

            Schema::table('stock_transactions', function (Blueprint $table) {

                $table->dropColumn('product_source');

            });

        }
    }
};