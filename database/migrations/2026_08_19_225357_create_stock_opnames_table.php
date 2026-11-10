<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_opnames', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | PRODUK
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | STOK SISTEM
            |--------------------------------------------------------------------------
            |
            | Stok yang tercatat di sistem sebelum dilakukan opname.
            |
            */

            $table->integer('system_stock');


            /*
            |--------------------------------------------------------------------------
            | STOK FISIK
            |--------------------------------------------------------------------------
            |
            | Jumlah barang yang benar-benar ditemukan
            | oleh Staff Gudang ketika melakukan pengecekan.
            |
            */

            $table->integer('physical_stock');


            /*
            |--------------------------------------------------------------------------
            | SELISIH
            |--------------------------------------------------------------------------
            |
            | physical_stock - system_stock
            |
            | Positif  = stok fisik lebih banyak
            | Negatif  = stok fisik lebih sedikit
            | 0        = stok sesuai
            |
            */

            $table->integer('difference');


            /*
            |--------------------------------------------------------------------------
            | KETERANGAN
            |--------------------------------------------------------------------------
            */

            $table->text('description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | STAFF
            |--------------------------------------------------------------------------
            |
            | User yang melakukan stock opname.
            |
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};