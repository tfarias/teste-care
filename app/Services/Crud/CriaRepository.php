<?php

namespace LaravelMetronic\Services\Crud;

use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Container\Container;

class CriaRepository
{
    protected $template;
    protected $eloquente;
    protected $tabela;
    protected $dbschema;
    protected $namespace;
    protected $repositoryProvider;

    public function __construct()
    {
        $this->template = 'app/Console/Commands/CreateCrud/Repository.txt';
        $this->eloquente = 'app/Console/Commands/CreateCrud/Eloquente.txt';
        $this->repositoryProvider = 'app/Providers/RepositoryServiceProvider.php';
        $this->namespace = Container::getInstance()->getNamespace();
    }

    public function criar($tabela)
    {
        $schema = new Schema($tabela);

        $this->tabela = $tabela;
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        $repository = File::get(base_path($this->template));
        $repository = str_replace('[{table}]', $classe, $repository);
        $repository = str_replace('[{namespace}]', $this->namespace, $repository);

        File::put(base_path('app/Repositories/' . $classe . 'Repository.php'), $repository);

        $eloquent = File::get(base_path($this->eloquente));
        $eloquent = str_replace('[{table}]', $classe, $eloquent);
        $eloquent = str_replace('[{namespace}]', $this->namespace, $eloquent);

        File::put(base_path('app/Repositories/' . $classe . 'RepositoryEloquent.php'), $eloquent);


        $provider = File::get(base_path($this->repositoryProvider));
        $uses = "";
        if (!strstr($provider, 'use ' . $this->namespace . 'Repositories\\' . $classe . 'Repository;')){
            $uses .= $schema->nlt(1) . 'use ' . $this->namespace . 'Repositories\\' . $classe . 'Repository;';
            $uses .= $schema->nlt(1).'use '.$this->namespace.'Repositories\\'.$classe.'RepositoryEloquent;';
            $uses .= $schema->nlt(1).'//[uses]';
            $provider = str_replace('//[uses]', $uses, $provider);
        }

        if (!strstr($provider, '$this->app->bind(' . $classe . 'Repository::class,' . $classe . 'RepositoryEloquent::class);')) {
            $prov = $schema->nlt(1) . '$this->app->bind(' . $classe . 'Repository::class,' . $classe . 'RepositoryEloquent::class);';
            $prov .= $schema->nlt(1) . '//[repository]';
            $provider = str_replace('//[repository]', $prov, $provider);
        }

        File::put(base_path('app/Providers/RepositoryServiceProvider.php'), $provider);

    }


}