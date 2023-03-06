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
        Schema::table('offerte', function (Blueprint $table) {
            $table->string('codice')->after('bando_id');
        });

        Schema::table('incarichi', function (Blueprint $table) {
            $table->string('codice')->after('assegnato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offerte', function (Blueprint $table) {
            $table->dropColumn('codice');
        });

        Schema::table('incarichi', function (Blueprint $table) {
            $table->dropColumn('codice');
        });
    }
};
