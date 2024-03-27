<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_izin', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('nomor_surat')->nullable();
            $table->binary('bukti')->nullable();
            $table->boolean('is_accepted')->nullable();
            $table->integer('id_mantri')->nullable()->index('id_mantri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_izin');
    }
};
