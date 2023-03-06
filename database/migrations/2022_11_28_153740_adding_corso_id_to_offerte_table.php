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
            $table->unsignedBigInteger('corso_id')->nullable()->after('bando_id');
            $table->foreign('corso_id')->references('id')->on('corsi')->onDelete('set null');
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
            $table->dropForeign(['corso_id']);
            $table->dropColumn('corso_id');
        });
    }
};
