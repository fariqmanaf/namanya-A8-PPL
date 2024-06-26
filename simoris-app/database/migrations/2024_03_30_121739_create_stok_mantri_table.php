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
        Schema::create('stok_mantri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('individuals_id')->nullable();
            $table->foreignId('jenis_semen_id')->nullable();
            $table->integer('total')->nullable();
            $table->integer('used')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_mantri');
    }
};
