<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | DATA PEMERIKSAAN STAFF GUDANG
            |--------------------------------------------------------------------------
            */

            $table->boolean('name_match')
                ->nullable()
                ->after('status');

            $table->boolean('attribute_match')
                ->nullable()
                ->after('name_match');

            $table->boolean('quantity_match')
                ->nullable()
                ->after('attribute_match');

            $table->string('condition')
                ->nullable()
                ->after('quantity_match');

        });
    }

    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {

            $table->dropColumn([
                'name_match',
                'attribute_match',
                'quantity_match',
                'condition',
            ]);

        });
    }
};