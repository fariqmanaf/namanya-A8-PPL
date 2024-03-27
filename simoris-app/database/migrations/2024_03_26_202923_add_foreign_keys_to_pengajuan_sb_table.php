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
        Schema::table('pengajuan_sb', function (Blueprint $table) {
            $table->foreign(['id_mantri'], 'pengajuan_sb_ibfk_1')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_jenis'], 'pengajuan_sb_ibfk_2')->references(['id'])->on('jenis_semen')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_sb', function (Blueprint $table) {
            $table->dropForeign('pengajuan_sb_ibfk_1');
            $table->dropForeign('pengajuan_sb_ibfk_2');
        });
    }
};
