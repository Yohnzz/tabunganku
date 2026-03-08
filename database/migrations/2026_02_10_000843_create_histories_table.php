<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('histories', function (Blueprint $table) {
        $table->id();
        $table->string('aksi'); // simpan / ambil
        $table->integer('jumlah');
        $table->integer('saldo_sebelum');
        $table->integer('saldo_sesudah');
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
