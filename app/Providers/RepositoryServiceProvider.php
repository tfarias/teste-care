<?php

namespace LaravelMetronic\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelMetronic\Repositories\SisUsuarioRepository;
use LaravelMetronic\Repositories\SisUsuarioRepositoryEloquent;
use LaravelMetronic\Repositories\AuxTipoUsuarioRepository;
use LaravelMetronic\Repositories\AuxTipoUsuarioRepositoryEloquent;


    use LaravelMetronic\Repositories\XmlUploadRepository;
    use LaravelMetronic\Repositories\XmlUploadRepositoryEloquent;
    
    use LaravelMetronic\Repositories\PessoasRepository;
    use LaravelMetronic\Repositories\PessoasRepositoryEloquent;
    
    use LaravelMetronic\Repositories\NotaPessoasRepository;
    use LaravelMetronic\Repositories\NotaPessoasRepositoryEloquent;
    
    use LaravelMetronic\Repositories\ProdutosRepository;
    use LaravelMetronic\Repositories\ProdutosRepositoryEloquent;
    
    use LaravelMetronic\Repositories\NotaProdutosRepository;
    use LaravelMetronic\Repositories\NotaProdutosRepositoryEloquent;
    //[uses]

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SisUsuarioRepository::class, SisUsuarioRepositoryEloquent::class);
        $this->app->bind(AuxTipoUsuarioRepository::class, AuxTipoUsuarioRepositoryEloquent::class);

        
    $this->app->bind(XmlUploadRepository::class,XmlUploadRepositoryEloquent::class);
    
    $this->app->bind(PessoasRepository::class,PessoasRepositoryEloquent::class);
    
    $this->app->bind(NotaPessoasRepository::class,NotaPessoasRepositoryEloquent::class);
    
    $this->app->bind(ProdutosRepository::class,ProdutosRepositoryEloquent::class);
    
    $this->app->bind(NotaProdutosRepository::class,NotaProdutosRepositoryEloquent::class);
    //[repository]
    }
}
