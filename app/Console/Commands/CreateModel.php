<?php

namespace LaravelMetronic\Console\Commands;

use LaravelMetronic\Services\Crud\CriaForms;
use LaravelMetronic\Services\Crud\CriaModel;
use LaravelMetronic\Services\Crud\CriarController;
use LaravelMetronic\Services\Crud\CriaRepository;
use LaravelMetronic\Services\Crud\CriaRequest;
use LaravelMetronic\Services\Crud\CriarRelatorio;
use LaravelMetronic\Services\Crud\CriaViews;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateModel extends Command
{

    protected $signature = 'create-model';

    protected $description = 'Cria apenas o model. por Tiago F. S.';


    /**
     * @var CriaModel
     */
    private $criaModel;


    public function __construct(
        CriaModel $criaModel
    ) {
        parent::__construct();

        $this->criaModel = $criaModel;

    }

    public function handle()
    {

        while (true) {
            $tabela = $this->ask("Qual a tabela?");


            echo "\n\n";
            echo "##############################################################\n";
            echo "####################### Conferir dados #######################\n";
            echo "##############################################################\n";
            echo "\n\n";
            echo "Tabela --------------------" . $tabela . "\n";


            echo "\n\n";

            $confirma = $this->ask("Confirma os dados abaixo (y/n)?");

            if (strtolower($confirma) != "y") {
                echo "\n\n";
                echo "##############################################################\n";
                echo "################## Reiniciando processo ######################\n";
                echo "##############################################################\n";
                echo "\n\n";
            } else {
                echo "\n\n";
                echo "GERANDO INFORMACOES.....................\n";
                break;
            }
        }



        try {
             // Agora vamos criar o model
            $this->criaModel->criar($tabela);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
