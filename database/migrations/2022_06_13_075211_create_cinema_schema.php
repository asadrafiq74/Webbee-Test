<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('movies', function($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('time');
            $table->boolean('is_booked')->default(0);
            $table->timestamps();
        });

        Schema::create('showrooms', function($table) {
            $table->increments('id');
            $table->string('showroom_name');
            $table->timestamps();
        });

        Schema::create('cinemas', function($table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_time');
            $table->integer('showroom_id')->unsigned()->nullable();
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('seat_types', function($table) {
            $table->increments('id');
            $table->string('seat_type');
            $table->timestamps();
        });

        Schema::create('seatings', function($table) {
            $table->increments('id');
            $table->integer('seat_type_id')->unsigned();
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');
            $table->string('ticket_no')->unique();
            $table->string('seat_no');
            $table->boolean('is_seat_booked')->default(0);
            $table->string('prices');
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
    }
}
