<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_0', function (Blueprint $table) {
            $table->bigIncrements('idt');
            $table->date('tgl_transaksi');
            $table->string('rekening_debit', 20);
            $table->string('rekening_kredit', 20);
            $table->unsignedBigInteger('idtp')->default(0);
            $table->unsignedBigInteger('id_pinj')->default(0);
            $table->unsignedBigInteger('id_pinj_i')->default(0);
            $table->unsignedBigInteger('id_simp')->nullable();
            $table->text('keterangan_transaksi')->nullable();
            $table->string('relasi', 100)->nullable();
            $table->decimal('jumlah', 18, 2)->default(0);
            $table->unsignedInteger('urutan')->default(0);
            $table->unsignedBigInteger('id_user')->default(0);

            $table->index('tgl_transaksi');
            $table->index('rekening_debit');
            $table->index('rekening_kredit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_0');
    }
};
