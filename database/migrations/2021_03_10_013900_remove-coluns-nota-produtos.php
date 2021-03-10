<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColunsNotaProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_produtos', function (Blueprint $table) {
            $table->dropColumn(['valor_icms','valor_pis','valor_cofins','valor_imposto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_produtos', function (Blueprint $table) {
            $table->decimal('valor_icms');
            $table->decimal('valor_pis');
            $table->decimal('valor_cofins');
        });
    }
}
