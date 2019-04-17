<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('contact_id');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->mediumText('contact_address')->nullable();
            $table->boolean('contact_gender');
            $table->boolean('contact_profile_picture')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
