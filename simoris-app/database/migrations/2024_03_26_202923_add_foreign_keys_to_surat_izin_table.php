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
        Schema::table('surat_izin', function (Blueprint $table) {
            $table->foreign(['id_mantri'], 'surat_izin_ibfk_1')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_izin', function (Blueprint $table) {
            $table->dropForeign('surat_izin_ibfk_1');
        });
    }
};
