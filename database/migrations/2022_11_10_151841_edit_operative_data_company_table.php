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
        Schema::table('companies', function(Blueprint $table) {
            $table->dropColumn(['indirizzo_operativo', 'comune_operativo', 'provincia_operativo', 'cap_operativo', 'regione_operativo', 'nazione_operativo']);
            $table->json('sedi')->nullable()->after('nazione_legale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
