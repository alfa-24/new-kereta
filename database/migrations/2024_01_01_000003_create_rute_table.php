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
        Schema::create('tb_rute', function (Blueprint $table) {
            $table->id('id_rute');
            $table->unsignedBigInteger('stasiun_asal');
            $table->unsignedBigInteger('stasiun_tujuan');
            $table->integer('durasi_menit');
            $table->decimal('jarak_km', 8, 2);
            $table->timestamps();

            // Foreign keys
            $table->foreign('stasiun_asal')
                ->references('id_stasiun')
                ->on('tb_stasiun')
                ->onDelete('cascade');
            
            $table->foreign('stasiun_tujuan')
                ->references('id_stasiun')
                ->on('tb_stasiun')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_rute');
    }
};
