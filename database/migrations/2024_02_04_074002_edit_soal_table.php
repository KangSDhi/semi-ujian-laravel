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
        Schema::table('soal', function(Blueprint $table){
            $table->dropForeign('soal_kelas_id_foreign');
            $table->dropColumn('kelas_id');

            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->unsignedBigInteger('tingkat_id');

            $table->foreign('jurusan_id')
                ->references('id')
                ->on('jurusan')
                ->onDelete('cascade');

            $table->foreign('tingkat_id')
                ->references('id')
                ->on('tingkat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
