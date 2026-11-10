<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {

            if (!Schema::hasColumn('suppliers', 'name')) {
                $table->string('name')->nullable();
            }

            if (!Schema::hasColumn('suppliers', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('suppliers', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('suppliers', 'address')) {
                $table->text('address')->nullable();
            }

            if (!Schema::hasColumn('suppliers', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('suppliers', 'status')) {
                $table->boolean('status')->default(true);
            }

        });
    }

    public function down(): void
    {
        //
    }
};

