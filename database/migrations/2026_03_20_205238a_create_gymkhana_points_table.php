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
        Schema::create('gymkhana_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gymkhana_id');
            $table->unsignedBigInteger('place_id');
            $table->integer('order');
            $table->text('question');
            $table->string('expected_answer');
            $table->text('next_clue')->nullable();
            $table->foreign('gymkhana_id')->references('id')->on('gymkhanas')->onDelete('cascade');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gymkhana_points');
    }
};
