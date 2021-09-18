<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('created_by');
            $table->string('username');
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('tags')->nullable();
            $table->string('type');
            $table->string('venue_name');
            $table->string('venue_address')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('registration_start_date')->nullable();
            $table->date('registration_end_date')->nullable();
            $table->integer('num_of_participant')->nullable();
            $table->integer('remaining_num_of_participant')->nullable();
            $table->string('publish_status');
            $table->string('event_status')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE events ADD cover_image LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
