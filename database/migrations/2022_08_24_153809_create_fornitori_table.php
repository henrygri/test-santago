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
        Schema::create('fornitori', function (Blueprint $table) {
            $table->id();
            $table->string('rag_soc')->nullable();
            $table->string('telefono')->nullable();
            $table->string('cellulare');
            $table->string('email');
            $table->string('codice_fiscale');
            $table->string('partita_iva');
            $table->string('disciplina');
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('via');
            $table->string('comune');
            $table->string('provincia');
            $table->string('cap');
            $table->string('nazione');
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
        Schema::dropIfExists('fornitori');
    }
};
