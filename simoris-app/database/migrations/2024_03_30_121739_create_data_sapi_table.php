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
            $table->id();
            $table->foreignId('jenis_sapi_id')->index('id_jenis');
            $table->foreignId('individuals_id')->index('id_peternak');
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
        Schema::dropIfExists('data_sapi');
    }
};
