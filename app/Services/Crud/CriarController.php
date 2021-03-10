<?php

namespace LaravelMetronic\Services\Crud;

use File;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Route;

class CriarController
{

    protected $template = 'app/Console/Commands/CreateCrud/controller.txt';
    protected $modelo_web = 'app/Console/Commands/CreateCrud/web.txt';
    protected $web = 'routes/web.php';
    protected $templateRotas = 'app/Console/Commands/CreateCrud/rotas.json';

    /**
     * Cria o model do CRUD.
     *
     * @param string $tabela
     * @param string $titulo
     * @param string $routeAs
     */
    public function criar($tabela, $titulo, $routeAs, $titulo_rota)
    {
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        $controller = File::get(base_path($this->template));
        $controller = str_replace('[{tabela}]', $tabela, $controller);
        $controller = str_replace('[{var}]', $tabela, $controller);
        $controller = str_replace('[{tabela_model}]', $classe, $controller);
        $controller = str_replace('[{titulo}]', $titulo, $controller);
        $controller = str_replace('[{namespace}]', Container::getInstance()->getNamespace(), $controller);
        File::put(base_path('app/Http/Controllers/' . $classe . 'Controller.php'), $controller);


        $this->atualizarRotas($routeAs, $classe);
        $this->atualizarJsonRotas($titulo, $routeAs, $titulo_rota);
    }

    /**
     * Atualiza o arquivo permissoes.json com as novas ações.
     *
     * @param $titulo
     * @param $routeAs
     */
    public function atualizarRotas($routeAs, $classe)
    {
        if (!Route::has($routeAs . '.index')) {
            $web = File::get(base_path($this->web));
            $modelo = File::get(base_path($this->modelo_web));
            $modelo = str_replace('[{prefix}]', $routeAs, $modelo);
            $modelo = str_replace('[{route_as}]', $routeAs, $modelo);
            $modelo = str_replace('[{classe}]', $classe, $modelo);
            $web = str_replace('//[rota]', $modelo, $web);
            File::put(base_path('routes/web.php'), $web);
        }
    }

    public function atualizarJsonRotas($titulo, $routeAs, $titulo_rota)
    {
        if (!Route::has($routeAs . '.index')) {
            $json = \Illuminate\Support\Facades\File::get(base_path('database/seeds/data/permissoes.json'));
            $rotas = json_decode($json, true);
            $modelo = File::get(base_path($this->templateRotas));
            $modelo = str_replace('[{titulo_rota}]', $titulo_rota, $modelo);
            $modelo = str_replace('[{titulo}]', $titulo, $modelo);
            $modelo = str_replace('[{route_as}]', $routeAs, $modelo);
            $modelo = json_decode($modelo);
            $rotas = array_merge($rotas, $modelo);
            File::put(base_path('database/seeds/data/permissoes.json'), json_encode($rotas, JSON_UNESCAPED_UNICODE));
        }
    }

}