<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotaProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_nota');
            $table->unsignedInteger('id_produto');
            $table->decimal('valor');
            $table->integer('quantidade');
            $table->decimal('valor_icms');
            $table->decimal('valor_pis');
            $table->decimal('valor_cofins');
            $table->decimal('valor_imposto');
            $table->timestamps();
            $table->foreign('id_nota')->references('id')->on('xml_upload')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_produto')->references('id')->on('produtos')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_produtos');
    }
}
