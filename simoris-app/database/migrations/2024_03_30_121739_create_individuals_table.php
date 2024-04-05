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
            $table->id();
            $table->string('nik')->nullable()->unique('nik');
            $table->string('name')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('no_telp')->nullable();
            $table->foreignId('alamats_id')->index('id_alamat');
            $table->string('wilayah_kerja')->nullable;
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
