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
        DB::statement("ALTER TABLE customers MODIFY stato_cliente ENUM('da_lavorare','contattato','da_ricontattare', 'parking', 'non_qualificato')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        DB::statement("ALTER TABLE customers MODIFY stato_cliente ENUM('da_lavorare','contattato','da_ricontattare', 'parking')");
    }
};
