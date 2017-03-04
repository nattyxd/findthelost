<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLostItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category');        // Pets/Electronics/Jewellery
            $table->string('title');           // Short description of the lost item
            $table->string('description');     // Long description of the lost item
            $table->boolean('reunited');       // should be item be displayed in search results, i.e. is the case closed?
            $table->boolean('lostitem');       // True if the item is lost, false is the item has been found by someone
            $table->string('image_url');       // URL to the item
            $table->string('addressline1');    // 
            $table->string('addressline2');    //
            $table->string('addressline3');    //
            $table->string('city');            //
            $table->string('postcode');        //
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
        Schema::dropIfExists('lost_items');
    }
}
