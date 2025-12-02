<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tabel Kandang
        Schema::create('kandangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kandang');
            $table->integer('kapasitas');
            $table->integer('jumlah_ayam')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Laporan Harian
        Schema::create('laporan_harians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kandang_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('jumlah_telur')->default(0);
            $table->integer('ayam_mati')->default(0);
            $table->integer('ayam_sakit')->default(0);
            $table->decimal('pakan_kg', 8, 2)->default(0);
            $table->decimal('suhu_kandang', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['kandang_id', 'tanggal']);
        });

        // Tabel Stok Pakan
        Schema::create('stok_pakans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pakan');
            $table->decimal('stok_kg', 10, 2)->default(0);
            $table->decimal('harga_per_kg', 10, 2)->nullable();
            $table->timestamps();
        });

        // Tabel Transaksi Pakan
        Schema::create('transaksi_pakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_pakan_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->decimal('jumlah_kg', 10, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_pakans');
        Schema::dropIfExists('stok_pakans');
        Schema::dropIfExists('laporan_harians');
        Schema::dropIfExists('kandangs');
    }
};