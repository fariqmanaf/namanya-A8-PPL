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
        Schema::create('data_sapi', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('id_jenis')->nullable()->index('id_jenis');
            $table->integer('id_peternak')->nullable()->index('id_peternak');
            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_sapi');
    }
};
