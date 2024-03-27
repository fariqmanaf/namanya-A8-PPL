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
        Schema::table('stok_mantri', function (Blueprint $table) {
            $table->foreign(['id_mantri'], 'stok_mantri_ibfk_1')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_semen'], 'stok_mantri_ibfk_2')->references(['id'])->on('jenis_semen')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stok_mantri', function (Blueprint $table) {
            $table->dropForeign('stok_mantri_ibfk_1');
            $table->dropForeign('stok_mantri_ibfk_2');
        });
    }
};
