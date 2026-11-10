<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClearStockifyData extends Command
{
    /**
     * Nama command.
     */
    protected $signature = 'stockify:clear-data';

    /**
     * Deskripsi command.
     */
    protected $description = 'Menghapus seluruh data testing Stockify tanpa menghapus akun pengguna';

    /**
     * Jalankan command.
     */
    public function handle()
    {
        $this->warn('==========================================');
        $this->warn('     CLEAR DATA TESTING STOCKIFY');
        $this->warn('==========================================');

        $this->newLine();

        if (!$this->confirm(
            'Yakin ingin menghapus seluruh data testing?'
        )) {
            $this->info('Dibatalkan. Tidak ada data yang dihapus.');

            return self::SUCCESS;
        }

        $this->newLine();

        DB::statement('PRAGMA foreign_keys = OFF');

        try {

            /*
            |--------------------------------------------------------------------------
            | HAPUS DATA STOCK OPNAME
            |--------------------------------------------------------------------------
            */

            DB::table('stock_opname_items')->delete();

            $this->line('✓ Stock opname items dibersihkan');

            DB::table('stock_opnames')->delete();

            $this->line('✓ Stock opname dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | HAPUS TRANSAKSI STOK
            |--------------------------------------------------------------------------
            */

            DB::table('stock_transactions')->delete();

            $this->line('✓ Transaksi stok dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | HAPUS RELASI ATRIBUT PRODUK
            |--------------------------------------------------------------------------
            */

            DB::table('product_attribute_product')->delete();

            $this->line('✓ Relasi atribut produk dibersihkan');

            DB::table('product_attribute_values')->delete();

            $this->line('✓ Nilai atribut produk dibersihkan');

            DB::table('product_variants')->delete();

            $this->line('✓ Varian produk dibersihkan');

            DB::table('product_attributes')->delete();

            $this->line('✓ Atribut produk dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | HAPUS PRODUK
            |--------------------------------------------------------------------------
            */

            DB::table('products')->delete();

            $this->line('✓ Produk dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | HAPUS KATEGORI
            |--------------------------------------------------------------------------
            */

            DB::table('categories')->delete();

            $this->line('✓ Kategori dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | HAPUS SUPPLIER
            |--------------------------------------------------------------------------
            */

            DB::table('suppliers')->delete();

            $this->line('✓ Supplier dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | HAPUS LOG AKTIVITAS
            |--------------------------------------------------------------------------
            */

            DB::table('activity_logs')->delete();

            $this->line('✓ Activity logs dibersihkan');

            DB::table('activities')->delete();

            $this->line('✓ Activities dibersihkan');


            /*
            |--------------------------------------------------------------------------
            | RESET AUTOINCREMENT
            |--------------------------------------------------------------------------
            */

            DB::statement(
                "DELETE FROM sqlite_sequence
                 WHERE name IN (
                    'categories',
                    'products',
                    'suppliers',
                    'stock_transactions',
                    'stock_opnames',
                    'stock_opname_items',
                    'product_variants',
                    'product_attributes',
                    'product_attribute_values',
                    'activity_logs',
                    'activities'
                 )"
            );

            $this->line('✓ Nomor ID dikembalikan ke awal');

        } finally {

            DB::statement('PRAGMA foreign_keys = ON');
        }

        $this->newLine();

        $this->info('==========================================');
        $this->info('       DATA STOCKIFY BERHASIL DIBERSIHKAN');
        $this->info('==========================================');

        $this->newLine();

        $this->info('Data yang DIHAPUS:');

        $this->line('  - Kategori');
        $this->line('  - Produk');
        $this->line('  - Supplier');
        $this->line('  - Transaksi barang masuk');
        $this->line('  - Transaksi barang keluar');
        $this->line('  - Stock opname');
        $this->line('  - Atribut & varian produk');
        $this->line('  - Activity log');

        $this->newLine();

        $this->info('Data yang TETAP ADA:');

        $this->line('  ✓ Akun Admin');
        $this->line('  ✓ Akun Manager Gudang');
        $this->line('  ✓ Akun Staff Gudang');
        $this->line('  ✓ Settings');
        $this->line('  ✓ Struktur database');
        $this->line('  ✓ Semua kode aplikasi');

        $this->newLine();

        return self::SUCCESS;
    }
}