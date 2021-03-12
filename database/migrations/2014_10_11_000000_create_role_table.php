<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name', 20);
            $table->timestamps();
        });
        DB::table('role')->insert(['name' => 'Super Admin']);
        DB::table('role')->insert(['name' => 'Sub Admin']);
        DB::table('role')->insert(['name' => 'School Admin']);
        DB::table('role')->insert(['name' => 'Instructor']);
        DB::table('role')->insert(['name' => 'Student']);
        DB::table('role')->insert(['name' => 'Visitor']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role');
    }
}
