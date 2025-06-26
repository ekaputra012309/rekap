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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('rincian_pemasukan');
            $table->decimal('nominal', 10, 2);
            $table->string('keterangan')->nullable();
            $table->foreignId('income_id')->constrained('incomes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('rincian_pengeluaran');
            $table->decimal('nominal', 10, 2);
            $table->string('keterangan')->nullable();
            $table->foreignId('income_id')->constrained('incomes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('gesss', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('nama_donatur');
            $table->integer('kaleng');
            $table->decimal('nominal', 10, 2);
            $table->string('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('dooms', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('nama_donatur');
            $table->decimal('nominal', 10, 2);
            $table->foreignId('bayar_id')->constrained('bayars')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('gibs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('nama_donatur');
            $table->decimal('nominal', 10, 2);
            $table->foreignId('bayar_id')->constrained('bayars')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gibs');
        Schema::dropIfExists('dooms');
        Schema::dropIfExists('gesss');
        Schema::dropIfExists('pengeluarans');
        Schema::dropIfExists('pemasukans');
    }
};
