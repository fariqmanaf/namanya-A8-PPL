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
        Schema::create('pengajuan_sb', function (Blueprint $table) {
            $table->id();
            $table->foreignId('individuals_id')->index('id_mantri');
            $table->foreignId('jenis_semen_id')->index('id_jenis');
            $table->integer('jumlah')->nullable();
            $table->boolean('is_taken')->nullable();
            $table->date('tanggal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_sb');
    }
};
