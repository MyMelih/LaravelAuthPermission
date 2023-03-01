<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Firma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firma', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('s_no')->nullable();
            $table->bigInteger('durum')->nullable();
            $table->bigInteger('devre_no')->nullable();
            $table->string('firma')->nullable();
            $table->string('lokasyon')->nullable();
            $table->bigInteger('devre_hizi')->nullable();
            $table->string('koordinat')->nullable();
            $table->bigInteger('bbk')->nullable();
            $table->bigInteger('uc_vlan')->nullable();
            $table->bigInteger('pop_vlan')->nullable();
            $table->string('turu')->nullable();
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
        Schema::dropIfExists('firma');
    }
}
