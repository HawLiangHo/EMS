<?php

use App\Models\Assistant;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Double;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assistants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('event_id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->integer('role'); //assistant-2
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('assistants')->insert(array(
            "event_id" => 1,
            "username" => "customer 1",
            "email" => "cust1@gmail.com",
            "phone" => "012-3456789",
            "role" => 2,
            "password" => Hash::make("1234"),
        ));

        DB::table('assistants')->insert(array(
            "event_id" => 2,
            "username" => "customer 2",
            "email" => "cust2@gmail.com",
            "phone" => "012-3456789",
            "role" => 2,
            "password" => Hash::make("1234"),
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assistants');
    }
}
