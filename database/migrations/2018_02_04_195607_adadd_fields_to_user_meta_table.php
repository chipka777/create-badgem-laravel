<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdaddFieldsToUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_meta', function (Blueprint $table) {
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();    
            $table->string('google')->nullable();   
            $table->string('linkedin')->nullable();  
            $table->text('about')->nullable();         
            $table->string('avatar')->default('/assets/img/user-medium.png');                                                                                   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_meta', function (Blueprint $table) {
            $table->dropColumn('facebook');
            $table->dropColumn('twitter');    
            $table->dropColumn('google');   
            $table->dropColumn('linkedin');  
            $table->dropColumn('about');    
            $table->dropColumn('avatar');
        });       
    }
}
