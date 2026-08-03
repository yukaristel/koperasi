<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pinjaman_anggota_0', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('jenis_pinjaman')->default(0);
            $table->unsignedBigInteger('id_pinkel')->default(0);
            $table->string('jenis_pp', 50)->nullable();
            $table->string('nia', 50)->nullable();
            $table->string('pendapatan', 100)->nullable();
            $table->string('biaya', 200)->nullable();
            $table->string('aktiva', 200)->nullable();
            $table->string('pasiva', 100)->nullable();
            $table->text('jaminan')->nullable();
            $table->text('data_proposal')->nullable();
            $table->text('data_verifikasi')->nullable();
            $table->text('data_verifikasi1')->nullable();
            $table->text('data_verifikasi2')->nullable();
            $table->text('data_verifikasi3')->nullable();
            $table->string('data_waiting', 200)->nullable();
            $table->date('tgl_cair')->nullable();
            $table->date('tgl_lunas')->nullable();
            $table->string('alokasi', 100)->nullable();
            $table->text('catatan')->nullable();
            $table->string('spk_no', 100)->nullable();
            $table->unsignedInteger('jangka')->default(0);
            $table->decimal('pros_jasa', 5, 2)->default(0);
            $table->string('jenis_jasa', 20)->nullable();
            $table->string('sistem_angsuran', 20)->nullable();
            $table->decimal('sa_jasa', 18, 2)->default(0);
            $table->string('status', 30)->nullable();
            $table->string('lu', 100)->nullable();
            $table->decimal('wt_cair', 18, 2)->default(0);
            $table->unsignedBigInteger('user_id')->default(0);

            $table->index('nia');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjaman_anggota_0');
    }
};
