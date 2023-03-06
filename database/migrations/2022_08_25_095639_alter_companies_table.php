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
            $table->dropColumn('settore');
            $table->unsignedBigInteger('settore_id')->after('rag_soc');
            $table->foreign('settore_id')->references('id')->on('settori');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function(Blueprint $table) {
            $table->dropForeign(['settore_id']);
            $table->dropColumn('settore_id');
        });
    }
};
