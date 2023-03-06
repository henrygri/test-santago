<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corsi', function(Blueprint $table) {
            $table->id();
            $table->string('titolo');
            $table->string('ore');
            $table->timestamps();
        });

        Schema::create('corsi_edizioni', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('corso_id');
            $table->foreign('corso_id')->references('id')->on('corsi')->onDelete('cascade');
            $table->string('edizione');
        });

        Schema::create('bandi_corsi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bando_id');
            $table->foreign('bando_id')->references('id')->on('bandi')->onDelete('cascade');
            $table->unsignedBigInteger('corso_id');
            $table->foreign('corso_id')->references('id')->on('corsi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corsi');
    }
};
