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

        Schema::create('bayars', function (Blueprint $table) {
            $table->id();
            $table->string('cara_bayar');
            $table->timestamps();
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_list_in');
            $table->timestamps();
        });

        Schema::create('outcomes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_list_out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('bayars');
        Schema::dropIfExists('outcomes');
    }
};
