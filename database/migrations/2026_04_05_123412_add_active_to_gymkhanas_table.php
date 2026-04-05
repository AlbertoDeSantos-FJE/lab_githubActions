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
        Schema::table('gymkhanas', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('min_members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gymkhanas', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
