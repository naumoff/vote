<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKittensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kittens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('animal_id')->unsigned()->index();
            $table->enum('fur',
	            [
					'bald',
		            'short-haired',
		            'long-haired',
                ]
            );
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('animal_id')
	            ->references('id')
	            ->on('animals')
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
        Schema::dropIfExists('kittens');
    }
}
