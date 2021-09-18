<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id');
            $table->string('name');
            $table->string('type');
            $table->integer('quantity');
            $table->integer('quantity_left');
            $table->double('price');
            $table->string('link');
            $table->timestamps();
        });

        // DB::statement("ALTER TABLE tickets ADD ticket_qr LONGBLOB");

        DB::table('tickets')->insert(array(
            'event_id' => 1,
            'name' => "Ticket 1",
            'type' => "General Admission",
            'quantity' => 10,
            'quantity_left' => 10,
            'price' => 1,
            'link' => "https://meet.google.com'",
        ));

        DB::table('tickets')->insert(array(
            'event_id' => 1,
            'name' => "Ticket 2",
            'type' => "General Admission",
            'quantity' => 10,
            'quantity_left' => 10,
            'price' => 5,
            'link' => "https://meet.google.com'",
        ));

        DB::table('tickets')->insert(array(
            'event_id' => 2,
            'name' => "Ticket 1",
            'type' => "General Admission",
            'quantity' => 10,
            'quantity_left' => 10,
            'price' => 5,
            'link' => "https://meet.google.com'",
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
