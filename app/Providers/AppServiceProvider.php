<?php

namespace LaravelMetronic\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use LaravelMetronic\Helpers\SearchArray;
use LaravelMetronic\Helpers\XmlParser;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $guesser = ExtensionGuesser::getInstance(); //take the guesser who will guess
        $guesser->register(new \LaravelMetronic\Helpers\PriorExtensionGuesser()); //add own guesser

        //funcao que valida se o cpf é o que foi determinado nos requisitos
        Validator::extend('cnpf_import', function ($attribute, $value, $parameters, $validator) {

            $file = file_get_contents($value);
            $xml   = simplexml_load_string($file);
            $array = XML2Array($xml);
            $search = new SearchArray();
            $inf = $search->return_by_key($array,"infNFe");
            if(!empty($inf['emit'])){
                $cnpj = @$inf['emit']['CNPJ'];
                return removerMascara(env('CNPJ_VERIFICAR')) === removerMascara($cnpj);
            }
            return false;

        });

        //validação se o nPort existe no xml
        Validator::extend('pront_nfe', function ($attribute, $value, $parameters, $validator) {
            $file = file_get_contents($value);
            $xml   = simplexml_load_string($file);
            $array = XML2Array($xml);
            $search = new SearchArray();
            return $search->search_array($array,"nProt");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'prod') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);

        }
        $this->app->bind(
            'bootstrapper::form',
            function ($app) {
                $form = new Form(
                    $app->make('collective::html'),
                    $app->make('url'),
                    $app->make('view'),
                    $app['session.store']->token()
                );

                return $form->setSessionStore($app['session.store']);
            },
            true
        );
    }
}
