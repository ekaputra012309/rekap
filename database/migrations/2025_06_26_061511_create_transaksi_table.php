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
        Schema::create('pemasukan_headers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->decimal('total', 15, 2)->default(0); // Add total to header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('pemasukan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemasukan_header_id')->constrained('pemasukan_headers')->onDelete('cascade');
            $table->foreignId('income_id')->nullable()->constrained('incomes')->onDelete('set null');
            $table->string('custom_rincian')->nullable();
            $table->string('keterangan')->nullable(); // Move here
            $table->decimal('nominal', 10, 2);
            $table->timestamps();
        });

        Schema::create('pengeluaran_headers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->decimal('total', 15, 2)->default(0); // Add total to header
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('pengeluaran_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengeluaran_header_id')->constrained('pengeluaran_headers')->onDelete('cascade');
            $table->foreignId('outcome_id')->nullable()->constrained('outcomes')->onDelete('set null');
            $table->string('custom_rincian')->nullable();
            $table->string('keterangan')->nullable(); // Move here
            $table->decimal('nominal', 10, 2);
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
        Schema::dropIfExists('pemasukan_headers');
        Schema::dropIfExists('pemasukan_details');
        Schema::dropIfExists('pengeluaran_headers');
        Schema::dropIfExists('pengeluaran_details');
    }
};
