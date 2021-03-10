<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableXmlUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xml_upload', function (Blueprint $table) {
            $table->increments('id');
			$table->string('path');
			$table->string('cuf');
			$table->string('cnf');
			$table->string('natop');
			$table->integer('mod');
			$table->integer('serie');
			$table->integer('numero_nota');
			$table->dateTime('data_nota');
			$table->string('aut_xml_cnpj',50);
			$table->decimal('valor_total');
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
        Schema::dropIfExists('xml_upload');
       
    }
}
