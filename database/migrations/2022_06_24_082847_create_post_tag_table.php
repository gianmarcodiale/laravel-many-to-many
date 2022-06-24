<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // Create foreign relations between tables with column creation
            $table->unsignedBigInteger('post_id')->nullable();
            // Assign values to the column
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            // Create foreign relations between tables with column creation
            $table->unsignedBigInteger('tag_id')->nullable();
            // Assign values to the column
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
        });
    }

    // See documentation /relationships for create relationships between tables and how to populate them and for methods attach(), detach() and sync()

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        // Here we only erase the table
        Schema::dropIfExists('post_tag');
    }
}
