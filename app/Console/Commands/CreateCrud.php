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

class CreateCrud extends Command
{

    protected $signature = 'create-crud';

    protected $description = 'Cria um crud default com repository. por Tiago F. S.';

    /**
     * @var CriaViews
     */
    private $criaViews;

    /**
     * @var CriaModel
     */
    private $criaModel;

    /**
     * @var CriaForms
     */
    private $criaForms;

    /**
     * @var CriaRepository
     */
    private $criaRepository;

    /**
     * @var CriarController
     */
    private $criarController;

    /**
     * @var CriarRelatorio
     */
    private $criarRelatorio;

    public function __construct(
        CriaViews $criaViews,
        CriaModel $criaModel,
        CriaForms $criaForms,
        CriaRepository $criaRepository,
        CriarController $criarController,
        CriarRelatorio $criarRelatorio
    ) {
        parent::__construct();

        $this->criaViews = $criaViews;
        $this->criaModel = $criaModel;
        $this->criaForms = $criaForms;
        $this->criaRepository = $criaRepository;
        $this->criarController = $criarController;
        $this->criarRelatorio = $criarRelatorio;
    }

    public function handle()
    {

        while (true) {
            $tabela = $this->ask("Qual a tabela?");
            $titulo = $this->ask("Qual o Titulo da view?");
            $tipo_rota= $this->ask("Qual o tipo de rota?");
            $routeAs = $tabela;


            echo "\n\n";
            echo "##############################################################\n";
            echo "####################### Conferir dados #######################\n";
            echo "##############################################################\n";
            echo "\n\n";
            echo "Tabela --------------------" . $tabela . "\n";
            echo "Titulo CRUD ---------------" . $titulo . "\n";
            echo "Titulo Rota ---------------" . $tipo_rota . "\n";
            echo "Alias (as) Rota -----------" . $routeAs . "\n";


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
            // Primeira coisa que fazemos é criar as views
            $this->criaViews->criar($tabela, $titulo, $routeAs);

             // Agora vamos criar o model
            $this->criaModel->criar($tabela);

            $this->criaForms->criar($tabela);

            $this->criaRepository->criar($tabela);

            $this->criarController->criar($tabela, $titulo, $routeAs,$tipo_rota);
            // Agora o controller
            // E por ultimo criamos o arquivo que é responsavel pelo Relatório (pela listagem dos registros na tabela)
            $this->criarRelatorio->criar($titulo, $tabela);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
