<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('era_id')->constrained('eras')->onDelete('cascade');
            $table->string('title');
            $table->integer('start_year');
            $table->integer('end_year')->nullable(); 
            $table->string('location')->nullable();
            $table->string('key_figures')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
