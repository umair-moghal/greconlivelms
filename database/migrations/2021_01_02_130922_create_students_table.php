<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('s_u_id')->unsigned()->nullable();
            $table->string('father_name');
            $table->string('phone');
            $table->string('cnic');
            $table->string('address');
            $table->string('class');
            $table->string('rollno');
            $table->string('blood_group');
            $table->string('diabetes');
            $table->string('alergy');
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
        Schema::dropIfExists('students');
    }
}
