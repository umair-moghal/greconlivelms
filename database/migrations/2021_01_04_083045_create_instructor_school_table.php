<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor_school', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('i_u_id');
            $table->unsignedBigInteger('sch_u_id');
            $table->timestamps();

            $table->foreign('sch_u_id')->references('id')->on('users');
            $table->foreign('i_u_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructor_school');
    }
}
