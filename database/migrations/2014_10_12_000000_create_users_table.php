<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('email', 60)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 60);
            // $table->rememberToken();
            $table->string('full_name', 150);
            $table->string('restaurant_name');
            $table->string('address');
            $table->string('vat_number', 16);
            $table->string('logo')->default('/storage/img/deliverooDefault');
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
        Schema::dropIfExists('users');
    }
}
