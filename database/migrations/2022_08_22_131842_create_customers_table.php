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
         // Ruoli customer
         Schema::create('ruoli', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cognome');
            $table->string('email')->unique();
            $table->enum('stato',[
                'lead',
                'contattato',
                'prospect',
                'cliente'
            ])->default('lead');
            $table->unsignedBigInteger('ruolo_id');
            $table->foreign('ruolo_id')->references('id')->on('ruoli')->onDelete('cascade');
            $table->enum('sorgente_acquisizione',[
                'social',
                'telefono',
                'sito',
                'email'
            ]);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('privato')->default(false);
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('email_aziendale')->nullable();
            $table->string('telefono_ufficio')->nullable();
            $table->string('telefono_personale')->nullable();
            $table->enum('stato_cliente',[
                'da_lavorare',
                'contattato',
                'da_ricontattare',
                'parking'
            ]);
            $table->date('data_creazione_lead')->nullable();
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
        Schema::dropIfExists('ruoli');
        Schema::dropIfExists('customers');
    }
};
