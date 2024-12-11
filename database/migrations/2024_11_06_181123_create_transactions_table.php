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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('parameter_id')->constrained('parameters');
            $table->string('category');
            $table->string('nama_penanggung_jawab');
            $table->string('identitas_penanggung_jawab');
            $table->string('email_penanggung_jawab');
            $table->string('no_hp_penanggung_jawab');
            $table->string('nama_instansi')->nullable();
            $table->string('email_instansi')->nullable();
            $table->string('telepon_instansi')->nullable();
            $table->string('alamat_instansi')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('file_surat')->nullable();
            $table->enum('pengembalian_sampel', ['ya', 'tidak'])->default('tidak');
            $table->enum('pengembalian_sisa_sampel', ['ya', 'tidak'])->default('tidak');
            $table->string('jenis_bahan_sampel')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
