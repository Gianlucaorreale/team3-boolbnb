<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('descriptive_title');
            $table->tinyInteger('num_rooms')->unsigned();
            $table->tinyInteger('num_bathroom')->unsigned();
            $table->tinyInteger('num_bed')->unsigned();
            $table->smallInteger('square_meters')->unsigned();
            $table->boolean('visibility')->nullable();
            $table->string('address');
            $table->decimal('latitude', 9,6)->default('44.49549');
            $table->decimal('longitude', 8,6)->default('11.33969');
            $table->text('image');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
