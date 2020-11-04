<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookedTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_times', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('catid');
            $table->text('description')->nullable();
            $table->integer('usedtime');
            $table->timestamp('date');
            $table->integer('userid');
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
        Schema::dropIfExists('booked_times');
    }
}
