<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger("idcard")->index();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('stage');
            $table->string('class');
            $table->string('degree')->nullable();
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('school_id')->index();
            $table->foreign('school_id')->references('moe_id')->on('schools')->onDelete('cascade');
            //$table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('teacher_id')->index();
            $table->foreign('teacher_id')->references('idcard')->on('teachers');
            //$table->foreignId('teacher_id')->constrained()->onDelete('cascade');
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
