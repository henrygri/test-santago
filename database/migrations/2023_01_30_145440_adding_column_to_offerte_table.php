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
            $table->enum('individuale_gruppo', ['individuale', 'gruppo'])->nullable()->after('note');
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
            $table->dropColumn('individuale_gruppo');
        });
    }
};
