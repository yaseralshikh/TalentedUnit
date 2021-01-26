<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger("idcard")->index();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('specialization')->nullable();
            $table->string('image')->default('default.png');
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger("school_id")->index();
            //$table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreign('school_id')->references('moe_id')->on('schools')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('teachers');
        Schema::enableForeignKeyConstraints();
    }
}
