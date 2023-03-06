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
        Schema::table('bandi', function (Blueprint $table) {
            $table->string('monte_ore')->nullable()->after('valore_finale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bandi', function (Blueprint $table) {
            $table->dropColumn('monte_ore');
        });
    }
};
