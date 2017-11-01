<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned()->index();
            $table->enum('type', ['kitten','puppy']);
            $table->string('name');
            $table->string('photo');
            $table->integer('victories')->default(0);
            $table->integer('failures')->default(0);
            $table->integer('score')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
