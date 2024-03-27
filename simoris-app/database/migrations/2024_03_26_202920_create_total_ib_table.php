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
            $table->integer('id')->primary();
            $table->integer('id_laporan')->nullable()->index('id_laporan');
            $table->integer('id_semen')->nullable()->index('id_semen');
            $table->dateTime('tgl_ib')->nullable();
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
