<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('login');
            //$table->string('email');
            $table->string('password');
            $table->time('start_day')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('sleeps', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_users')->unsigned();
            $table->foreign("id_users")->references("id")->on("users");
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->integer('how_wake_up')->nullable();
            $table->timestamps();
        });
        Schema::create('moods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->integer('id_users')->unsigned();
            $table->foreign("id_users")->references("id")->on("users");
            $table->float('level_mood');
            $table->float('level_anxiety');
            $table->float('level_nervousness');
            $table->float('level_stimulation');
            $table->integer('epizodes_psychotik')->nullable();
            $table->text('what_work')->nullable();
            
            $table->timestamps();
        });
        Schema::create('drugs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->float('dose');
            $table->datetime('date');
            $table->integer("id_users")->unsigned();
            $table->foreign("id_users")->references("id")->on("users");
            $table->integer('type');
            
            
            $table->timestamps();
        });
        Schema::create('forwarding_drugs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_drugs')->unsigned();
            $table->foreign("id_drugs")->references("id")->on("drugs");
            $table->integer('id_mood')->unsigned();
            $table->foreign("id_mood")->references("id")->on("moods");
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('sleeps');
        Schema::dropIfExists('moods');
        Schema::dropIfExists('drugs');
        Schema::dropIfExists('forwarding_drugs');
    }
}
