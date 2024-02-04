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
        Schema::table('users', function(Blueprint $table){
            $table->dropForeign('users_jurusan_id_foreign');
            $table->dropColumn('jurusan_id');

            $table->unsignedBigInteger('sub_kelas_id')->nullable();

            $table->foreign('sub_kelas_id')
                ->references('id')
                ->on('sub_kelas')
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
