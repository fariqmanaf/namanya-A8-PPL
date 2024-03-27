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
        Schema::table('alamat', function (Blueprint $table) {
            $table->foreign(['id_kabupaten'], 'alamat_ibfk_1')->references(['id'])->on('kabupaten')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_kecamatan'], 'alamat_ibfk_2')->references(['id'])->on('kecamatan')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_kelurahan'], 'alamat_ibfk_3')->references(['id'])->on('kelurahan')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alamat', function (Blueprint $table) {
            $table->dropForeign('alamat_ibfk_1');
            $table->dropForeign('alamat_ibfk_2');
            $table->dropForeign('alamat_ibfk_3');
        });
    }
};
