<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('animal_id_1')->unsigned()->index();
            $table->integer('animal_id_2')->unsigned()->index();
            $table->integer('animal_picked_id');
            $table->softDeletes();
            $table->timestamps();
	        $table->foreign('user_id')
		        ->references('id')
		        ->on('users')
	            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_votes');
    }
}
