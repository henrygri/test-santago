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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('rag_soc');
            $table->string('cod_fisc')->nullable();
            $table->string('p_iva')->nullable();
            $table->string('p_iva_collegata')->nullable();
            $table->enum('tipo', ['nuovo', 'in lavorazione', 'da ricontattare', 'prospect', 'non interessato', 'cliente'])->nullable();
            $table->date('data_ricontattare')->nullable();
            $table->string('indirizzo_legale')->nullable();
            $table->string('comune_legale')->nullable();
            $table->string('provincia_legale')->nullable();
            $table->string('cap_legale')->nullable();
            $table->string('regione_legale')->nullable();
            $table->string('nazione_legale')->nullable();
            $table->string('indirizzo_operativo')->nullable();
            $table->string('comune_operativo')->nullable();
            $table->string('provincia_operativo')->nullable();
            $table->string('cap_operativo')->nullable();
            $table->string('regione_operativo')->nullable();
            $table->string('nazione_operativo')->nullable();
            $table->enum('tipologia_organizzativa', ['multinazionale', 'padronale manageriale', 'padronale'])->nullable();
            $table->string('fatturato_annuo')->nullable();
            $table->string('n_dipendenti')->nullable();
            $table->string('settore');
            $table->date('data_contatto')->nullable();
            $table->text('come_ci_ha_conosciuto')->nullable();
            $table->string('fondo_dirigenti')->nullable();
            $table->enum('fondo_non_dirigenti', [
                'FONDIMPRESA',
                'FORTE',
                'FONDOBANCHE',
                'FONARCOM',
                'FORMAZIENDA',
                'FONTER',
                'FONDARTIGIANATO',
                'FONDOPMI',
                'FONDITALIA',
                'FONDOPROFESSIONI',
                'FONDOLAVORO',
                'FONCOOP'
            ])->nullable();
            $table->boolean('rsa_rsu')->default(0);
            $table->text('fornitori_attuali')->nullable();
            $table->string('potenziale_fatturato_formazione')->nullable();
            $table->string('potenziale_fatturato_selezione')->nullable();
            $table->string('potenziale_fatturato_pal')->nullable();
            $table->string('potenziale_fatturato_consulenza')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
