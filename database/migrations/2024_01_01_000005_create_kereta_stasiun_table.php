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
        Schema::create('tb_kereta_stasiun', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kereta');
            $table->unsignedBigInteger('id_stasiun');
            $table->integer('urutan');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kereta')
                ->references('id_kereta')
                ->on('tb_kereta')
                ->onDelete('cascade');
            
            $table->foreign('id_stasiun')
                ->references('id_stasiun')
                ->on('tb_stasiun')
                ->onDelete('cascade');
            
            // Unique constraint untuk menghindari duplikasi urutan kereta yang sama
            $table->unique(['id_kereta', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kereta_stasiun');
    }
};
