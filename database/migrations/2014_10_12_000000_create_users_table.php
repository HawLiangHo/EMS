<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Expr\Cast\Double;

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
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->integer('role'); //admin-0, participant-1
            $table->string('address')->nullable();
            $table->double('credit_balance')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            "email" => "peter@gmail.com",
            "username" => "peter",
            "phone" => "012-3456789",
            "role" => 0,
            "password" => Hash::make("1234"),
            "credit_balance" => 0
        ]);

        User::create([
            "email" => "customer@gmail.com",
            "username" => "customer",
            "phone" => "012-3456789",
            "role" => 1,
            "password" => Hash::make("1234"),
            "credit_balance" => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
