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
        Schema::table('data_sapi', function (Blueprint $table) {
            $table->foreign(['id_jenis'], 'data_sapi_ibfk_1')->references(['id'])->on('jenis_sapi')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_peternak'], 'data_sapi_ibfk_2')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_sapi', function (Blueprint $table) {
            $table->dropForeign('data_sapi_ibfk_1');
            $table->dropForeign('data_sapi_ibfk_2');
        });
    }
};
