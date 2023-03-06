<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE customers MODIFY sorgente_acquisizione ENUM('social', 'telefono', 'sito', 'email', 'chiamata a freddo', 'campagna web', 'passaparola', 'dipendente', 'partner', 'evento online', 'convegno') NOT NULL");

        Schema::table('customers', function(Blueprint $table) {
            $table->string('email_aziendale_generica')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE customers MODIFY sorgente_acquisizione ENUM('social', 'telefono', 'sito', 'email') NOT NULL");

        Schema::table('customers', function(Blueprint $table) {
            $table->dropColumn('email_aziendale_generica');
        });
    }
};
