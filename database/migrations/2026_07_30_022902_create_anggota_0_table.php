<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_0', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik', 30)->nullable();
            $table->string('namadepan', 100)->nullable();
            $table->string('nama_panggilan', 100)->nullable();
            $table->string('jk', 5)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('domisi', 100)->nullable();
            $table->string('desa', 100)->nullable();
            $table->unsignedInteger('lokasi')->default(0);
            $table->string('hp', 30)->nullable();
            $table->string('kk', 30)->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('status_pernikahan', 30)->nullable();
            $table->string('nik_penjamin', 30)->nullable();
            $table->string('penjamin', 100)->nullable();
            $table->string('hubungan', 50)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('tempat_kerja', 100)->nullable();
            $table->string('usaha', 100)->nullable();
            $table->text('keterangan_usaha')->nullable();
            $table->string('foto', 255)->nullable();
            $table->date('terdaftar')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('petugas', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_0');
    }
};
