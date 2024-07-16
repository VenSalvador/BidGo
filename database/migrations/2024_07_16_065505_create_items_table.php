<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_client');
            $table->float('item_weight');
            $table->string('item_from');
            $table->string('item_destination');
            $table->timestamp('item_pickup_time');
            $table->timestamp('item_dropoff_time')->nullable(); // Option 1: Make nullable
            // $table->timestamp('item_dropoff_time')->useCurrent(); // Option 2: Set default value
            $table->decimal('item_quote', 10, 2);
            $table->string('item_image')->nullable();
            $table->float('item_length');
            $table->float('item_width');
            $table->float('item_height');
            $table->string('item_status');
            $table->integer('item_current_bids')->default(0);
            $table->boolean('is_bid_placed')->default(false);
            $table->text('description')->nullable();
            $table->string('vehicle_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
