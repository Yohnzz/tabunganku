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
    Schema::create('list_pembelians', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang');
        $table->integer('harga');
        $table->integer('prioritas')->default(1); // 1 = paling penting
        $table->boolean('dibeli')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_pembelians');
    }
};
