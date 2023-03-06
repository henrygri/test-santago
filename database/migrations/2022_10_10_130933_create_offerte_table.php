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
        Schema::create('offerte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('bando_id');
            $table->foreign('bando_id')->references('id')->on('bandi')->onDelete('cascade');
            $table->text('description');
            $table->date('data_richiesta_preventivo');
            $table->date('data_scadenza_preventivo');
            $table->enum('stato', ['in attesa', 'accettata', 'rifiutata'])->default('in attesa');
            $table->string('val_offerta_tot');
            $table->boolean('finanziamento')->default(false);
            $table->string('val_offerta_no_finanz')->nullable();
            $table->string('val_offerta_finanz')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('offerte_servizi', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offerta_id');
            $table->foreign('offerta_id')->references('id')->on('offerte')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offerte_servizi');
        Schema::dropIfExists('offerte');
    }
};
