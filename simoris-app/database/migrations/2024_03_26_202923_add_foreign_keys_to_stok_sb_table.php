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
        Schema::table('stok_sb', function (Blueprint $table) {
            $table->foreign(['id_kecamatan'], 'stok_sb_ibfk_1')->references(['id'])->on('kecamatan')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_jenis'], 'stok_sb_ibfk_2')->references(['id'])->on('jenis_semen')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stok_sb', function (Blueprint $table) {
            $table->dropForeign('stok_sb_ibfk_1');
            $table->dropForeign('stok_sb_ibfk_2');
        });
    }
};
