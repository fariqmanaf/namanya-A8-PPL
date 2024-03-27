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
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->foreign(['id_individual'], 'user_accounts_ibfk_1')->references(['id'])->on('individuals')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_roles'], 'user_accounts_ibfk_2')->references(['id'])->on('roles')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_accounts', function (Blueprint $table) {
            $table->dropForeign('user_accounts_ibfk_1');
            $table->dropForeign('user_accounts_ibfk_2');
        });
    }
};
