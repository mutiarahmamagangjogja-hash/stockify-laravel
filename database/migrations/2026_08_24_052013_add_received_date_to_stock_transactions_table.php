<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('stock_transactions', 'received_date')) {
            Schema::table('stock_transactions', function (Blueprint $table) {
                $table->date('received_date')->nullable()->after('received_at');
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
    }
};
