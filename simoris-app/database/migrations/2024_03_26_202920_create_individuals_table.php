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
        Schema::create('individuals', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nik')->nullable()->unique('nik');
            $table->string('name')->nullable();
            $table->dateTime('tgl_lahir')->nullable();
            $table->string('no_telp')->nullable();
            $table->integer('id_alamat')->nullable()->index('id_alamat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('individuals');
    }
};