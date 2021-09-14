<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('events')->insert(array(
            'user_id' => '1',
            'username' => 'peter',
            'title' => 'Webinar on Quick Maths',
            'description' => 'Quick Learning on how to do Maths quick!',
            'category' => 'Class / Training / Workshop',
            'tags' => 'no tags',
            'type' => 'Virtual Event',
            'venue_name' => 'Zoom',
            'venue_address' => 'No address',
            'start_date' => '2021-10-01',
            'end_date' => '2021-10-10',
            'start_time' => '09:30:00',
            'end_time' => '10:30:00',
            'registration_start_date' => '2021-10-01',
            'registration_end_date' => '2021-10-09',
            'num_of_participant' => 30,
            'publish_status' => "Not published",
            'event_status' => "Pending",
            'created_at' => '2021-09-14 09:14:05',
            'updated_at' => '2021-09-14 09:14:05',
            'cover_image' => file_get_contents("public\assets\img\cover3.jpg")
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
