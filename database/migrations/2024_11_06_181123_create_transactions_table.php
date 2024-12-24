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
            $table->string('category');
            $table->string('phone');
            $table->string('instansi')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('file_surat')->nullable();
            $table->foreignId('province_id')->constrained('indonesia_provinces');
            $table->foreignId('city_id')->constrained('indonesia_cities');
            $table->foreignId('district_id')->constrained('indonesia_districts');
            $table->string('address');
            $table->boolean('status_pengembalian_sisa')->default(false);
            $table->boolean('status_pengembalian_hasil')->default(false);
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
