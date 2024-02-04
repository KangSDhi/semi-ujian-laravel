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
        Schema::create('soal', function (Blueprint $table) {
            $table->id();
            $table->string('nama_soal');
            $table->string('link');
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->datetime('waktu_mulai');
            $table->timestamps();

            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
    }
};
