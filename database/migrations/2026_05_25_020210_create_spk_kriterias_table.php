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
        Schema::create('spk_kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kriteria');
            $table->float('bobot');
            $table->enum('tipe', ['max', 'min']);
            $table->string('fungsi_preferensi');
            $table->float('p_parameter')->nullable();
            $table->float('q_parameter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spk_kriterias');
    }
};
