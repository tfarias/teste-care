<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotaPessoas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_nota');
            $table->unsignedInteger('id_pessoa');
            $table->enum('tipo',['E','C'])->default('E');
            $table->timestamps();
            $table->foreign('id_nota')->references('id')->on('xml_upload')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_pessoa')->references('id')->on('pessoas')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_pessoas');
    }
}
