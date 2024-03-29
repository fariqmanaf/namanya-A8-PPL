<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('id_individual')->nullable()->index('id_individual');
            $table->string('email')->nullable()->unique('email');
            $table->string('password')->static::$password ??= Hash::make('password');
            $table->string('status')->default('disable');
            $table->integer('id_roles')->nullable()->index('id_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
};
