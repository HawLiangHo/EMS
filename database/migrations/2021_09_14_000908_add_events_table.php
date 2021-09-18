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
            'tags' => '',
            'type' => 'Virtual Event',
            'venue_name' => 'Zoom',
            'venue_address' => '',
            'start_date' => '2021-10-01',
            'end_date' => '2021-10-10',
            'start_time' => '09:30:00',
            'end_time' => '10:30:00',
            'registration_start_date' => '2021-10-01',
            'registration_end_date' => '2021-10-09',
            'num_of_participant' => 30,
            'remaining_num_of_participant' => 30,
            'publish_status' => "Not published",
            'event_status' => "Pending",
            'created_at' => '2021-09-14 09:14:05',
            'updated_at' => '2021-09-14 09:14:05',
            'cover_image' => file_get_contents("public\assets\img\cover3.jpg")
        ));

        DB::table('events')->insert(array(
            'user_id' => '1',
            'username' => 'peter',
            'title' => 'Lesson on Easy English',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur feugiat hendrerit ultrices. Etiam tristique dictum elementum. Aenean nec sem ut risus mollis eleifend at quis magna. Mauris at pretium ligula. Maecenas ligula sapien, tempus ut lectus sit amet, blandit dapibus urna. Donec malesuada ex ligula, sit amet consequat neque mattis id. Sed auctor vulputate dui a posuere. Nam dignissim turpis in mauris fringilla, ac mattis nulla vulputate. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque in libero ac eros maximus interdum. Mauris nec posuere turpis, sed varius orci. Morbi scelerisque nisi sed interdum viverra. Donec id tortor sem. Sed egestas, leo at pharetra vehicula, sapien velit pharetra nisl, in mollis arcu nisi eget nisl.

            Integer leo lorem, vehicula eu nisl rutrum, dapibus finibus ligula. Curabitur consectetur finibus ex, sit amet aliquam mauris laoreet porta. Donec laoreet dolor eu ex mattis tincidunt. Donec egestas elementum blandit. Aenean sodales enim quis leo hendrerit, lobortis tristique elit condimentum. Vivamus gravida eget nisl eget sagittis. Curabitur eget massa id nisl eleifend aliquet. Duis eleifend tortor erat, ac dapibus nisi tempor id. Vestibulum bibendum lorem leo, id convallis lacus gravida ac. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer eget ante lorem. Sed scelerisque velit laoreet consectetur blandit. Vivamus sit amet eros non enim rhoncus sodales sit amet bibendum ipsum.
            
            Nulla egestas orci eget neque placerat vehicula. Aenean vitae enim malesuada, malesuada sapien ut, interdum quam. Fusce placerat massa lorem, in rutrum enim suscipit quis. Mauris congue, elit non bibendum finibus, lectus eros vestibulum quam, vehicula euismod justo felis sit amet lectus. Integer malesuada ultricies enim at ultrices. Aliquam mauris eros, convallis nec posuere non, posuere sit amet tellus. Mauris risus eros, aliquam a maximus nec, euismod a nisi. Integer laoreet, nibh sit amet volutpat varius, massa tortor eleifend est, ut euismod ipsum tellus et felis. Sed at dui in diam viverra blandit et et eros. Duis bibendum mauris eget erat fringilla, nec tristique ex commodo. Vivamus at risus a elit lacinia posuere sit amet vel dolor. Quisque varius ornare metus vel aliquam. Nulla placerat dictum risus non lobortis. Pellentesque placerat facilisis ante, sit amet fringilla massa ultrices ut. Etiam bibendum imperdiet justo vitae pellentesque.',
            'category' => 'Seminar / Talk',
            'tags' => '#seminar#talk#language',
            'type' => 'Virtual Event',
            'venue_name' => 'Meet',
            'venue_address' => '',
            'start_date' => '2021-10-01',
            'end_date' => '2021-10-10',
            'start_time' => '09:30:00',
            'end_time' => '10:30:00',
            'registration_start_date' => '2021-10-01',
            'registration_end_date' => '2021-10-09',
            'num_of_participant' => 30,
            'remaining_num_of_participant' => 30,
            'publish_status' => "Published",
            'event_status' => "Closed",
            'created_at' => '2021-09-14 09:14:05',
            'updated_at' => '2021-09-14 09:14:05',
            'cover_image' => file_get_contents("public\assets\img\cover2.png")
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
