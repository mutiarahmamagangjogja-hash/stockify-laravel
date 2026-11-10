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
        | SUPPLIER ID
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'supplier_id')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->foreignId('supplier_id')
                    ->nullable()
                    ->after('product_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | RECEIVED AT
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'received_at')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->dateTime('received_at')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'status')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->string('status')
                    ->default('pending');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'notes')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->text('notes')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | PRODUCT MATCH
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'product_match')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->boolean('product_match')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | ATTRIBUTE MATCH
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'attribute_match')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->boolean('attribute_match')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | QUANTITY MATCH
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'quantity_match')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->boolean('quantity_match')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | CONDITION
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'condition')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->string('condition')
                    ->nullable();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | INSPECTION NOTES
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('stock_transactions', 'inspection_notes')) {

            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->text('inspection_notes')
                    ->nullable();
            });
        }
    }


    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | HANYA HAPUS KOLOM YANG MEMANG ADA
        |--------------------------------------------------------------------------
        */

        $columns = [
            'supplier_id',
            'received_at',
            'status',
            'notes',
            'product_match',
            'attribute_match',
            'quantity_match',
            'condition',
            'inspection_notes',
        ];


        foreach ($columns as $column) {

            if (Schema::hasColumn('stock_transactions', $column)) {

                Schema::table(
                    'stock_transactions',
                    function (Blueprint $table) use ($column) {

                        $table->dropColumn($column);
                    }
                );
            }
        }
    }
};
