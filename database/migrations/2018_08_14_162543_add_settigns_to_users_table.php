<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettignsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_settings', function (Blueprint $table) {
            $table->integer('user_id');            
            $table->integer('invited_by')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('rank_level')->nullable();            
            $table->string('age')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_settings');
    }
}
