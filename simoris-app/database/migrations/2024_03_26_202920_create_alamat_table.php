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
        Schema::create('alamat', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('id_kabupaten')->nullable()->index('id_kabupaten');
            $table->integer('id_kecamatan')->nullable()->index('id_kecamatan');
            $table->integer('id_kelurahan')->nullable()->index('id_kelurahan');
            $table->string('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alamat');
    }
};
