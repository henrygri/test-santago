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
        Schema::create('commesse', function(Blueprint $table) {
            $table->id();
            $table->string('codice');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('offerta_id');
            $table->foreign('offerta_id')->references('id')->on('offerte')->onDelete('cascade');
            $table->text('description');
            $table->date('data_apertura');
            $table->date('data_stim_chiusura');
            $table->date('data_effettiva_chiusura')->nullable();
            $table->string('val_iniziale');
            $table->string('val_finale')->nullable();
            $table->string('val_no_finanz');
            $table->string('val_finanz')->nullable();
            $table->boolean('stato')->default(0);
            $table->timestamps();
        });

        Schema::create('incarichi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fornitore_id');
            $table->foreign('fornitore_id')->references('id')->on('fornitori')->onDelete('cascade');
            $table->unsignedBigInteger('commessa_id');
            $table->foreign('commessa_id')->references('id')->on('commesse')->onDelete('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('offerta_id');
            $table->foreign('offerta_id')->references('id')->on('offerte')->onDelete('cascade');
            $table->unsignedBigInteger('bando_id')->nullable();
            $table->foreign('bando_id')->references('id')->on('bandi')->onDelete('cascade');
            $table->unsignedBigInteger('responsabile');
            $table->foreign('responsabile')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('assegnato');
            $table->foreign('assegnato')->references('id')->on('users')->onDelete('cascade');
            $table->json('attivita');
            $table->string('numero_edizione')->nullable();
            $table->date('data_inizio');
            $table->date('data_fine');
            $table->string('ore');
            $table->string('costo_orario');
            $table->enum('tempi_pagamento', ['30','60','90','30-60-90'])->nullable();
            $table->enum('spese', ['previste','non previste'])->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('incarichi_servizi', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('incarico_id');
            $table->foreign('incarico_id')->references('id')->on('incarichi')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incarichi_servizi');
        Schema::dropIfExists('incarichi');
        Schema::dropIfExists('commesse');
    }
};
