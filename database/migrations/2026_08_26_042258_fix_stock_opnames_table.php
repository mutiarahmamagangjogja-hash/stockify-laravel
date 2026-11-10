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
        Schema::table('stock_opnames', function (Blueprint $table) {

            if (!Schema::hasColumn(
                'stock_opnames',
                'product_id'
            )) {

                $table->foreignId('product_id')
                    ->nullable()
                    ->constrained('products')
                    ->nullOnDelete();
            }


            if (!Schema::hasColumn(
                'stock_opnames',
                'system_stock'
            )) {

                $table->integer(
                    'system_stock'
                )->default(0);
            }


            if (!Schema::hasColumn(
                'stock_opnames',
                'physical_stock'
            )) {

                $table->integer(
                    'physical_stock'
                )->default(0);
            }


            if (!Schema::hasColumn(
                'stock_opnames',
                'difference'
            )) {

                $table->integer(
                    'difference'
                )->default(0);
            }


            if (!Schema::hasColumn(
                'stock_opnames',
                'description'
            )) {

                $table->text(
                    'description'
                )->nullable();
            }


            if (!Schema::hasColumn(
                'stock_opnames',
                'user_id'
            )) {

                $table->foreignId(
                    'user_id'
                )
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            }

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_opnames', function (Blueprint $table) {

            if (Schema::hasColumn(
                'stock_opnames',
                'product_id'
            )) {
                $table->dropForeign([
                    'product_id'
                ]);

                $table->dropColumn(
                    'product_id'
                );
            }


            if (Schema::hasColumn(
                'stock_opnames',
                'system_stock'
            )) {
                $table->dropColumn(
                    'system_stock'
                );
            }


            if (Schema::hasColumn(
                'stock_opnames',
                'physical_stock'
            )) {
                $table->dropColumn(
                    'physical_stock'
                );
            }


            if (Schema::hasColumn(
                'stock_opnames',
                'difference'
            )) {
                $table->dropColumn(
                    'difference'
                );
            }


            if (Schema::hasColumn(
                'stock_opnames',
                'description'
            )) {
                $table->dropColumn(
                    'description'
                );
            }


            if (Schema::hasColumn(
                'stock_opnames',
                'user_id'
            )) {
                $table->dropForeign([
                    'user_id'
                ]);

                $table->dropColumn(
                    'user_id'
                );
            }

        });
    }
};