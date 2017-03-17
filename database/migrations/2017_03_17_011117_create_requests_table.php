<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id'); // the user id of the request
            $table->integer('lost_item_id'); // the id of the lost/found item in question
            $table->tinyInteger('approved'); // is the request approved by an admin?
            $table->tinyInteger('adminhandled'); // has the admin actioned the claim?
            $table->string('reason'); // the reason for the request
            $table->string('image_url'); // an image to provide proof of ownership/finding the item
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_requests');
    }
}
