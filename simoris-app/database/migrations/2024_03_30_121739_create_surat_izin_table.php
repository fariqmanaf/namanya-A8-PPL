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
            $table->id();
            $table->bigInteger('nomor_surat')->nullable();
            $table->string('bukti');
            $table->date('tanggal_pembuatan');
            $table->date('tanggal_expired');
            $table->boolean('is_accepted')->nullable();
            $table->foreignId('individuals_id')->nullable();
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
