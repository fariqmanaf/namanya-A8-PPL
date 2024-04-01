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
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_sertifikasi')->nullable();
            $table->binary('bukti')->nullable();
            $table->boolean('is_accepted')->nullable();
            $table->foreignId('individuals_id')->index('id_mantri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikasi');
    }
};
