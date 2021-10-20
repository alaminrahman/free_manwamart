<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFbreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fbreviews', function (Blueprint $table) {
            $table->id();
            $table->integer('pageid');
            $table->string('reviewer_name');
            $table->integer('reviewer_id');
            $table->string('recommendation_type');
            $table->string('review_text');
            $table->string('user_pic');
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
        Schema::dropIfExists('fbreviews');
    }
}
