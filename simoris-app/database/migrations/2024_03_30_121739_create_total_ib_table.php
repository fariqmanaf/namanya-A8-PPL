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
        Schema::create('total_ib', function (Blueprint $table) {
            $table->id();
            $table->integer('laporan_ib_id')->index('id_laporan');
            $table->integer('jenis_semen')->index('id_semen');
            $table->date('tgl_ib')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('total_ib');
    }
};
