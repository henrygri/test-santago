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
        Schema::create('bandi', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codice');
            $table->date('data_apertura');
            $table->date('data_chiusura');
            $table->date('data_chiusura_prorogata')->nullable();
            $table->json('corsi')->nullable();
            $table->string('valore_iniziale');
            $table->string('valore_finale')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('bandi');
    }
};
