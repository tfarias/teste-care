<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePessoas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome',255);
            $table->string('nome_fantasia',255)->nullable();
            $table->string('cpf_cnpj',50)->unique();
            $table->string('logradouro',255);
            $table->string('numero',10);
            $table->string('bairro',255);
            $table->integer('cod_municipio');
            $table->string('municipio',255);
            $table->string('uf',10);
            $table->string('cep',20);
            $table->integer('codigo_pais');
            $table->string('inscricao_estadual')->nullable();
            $table->string('inscricao_municipal')->nullable();
            $table->string('crt')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
}
