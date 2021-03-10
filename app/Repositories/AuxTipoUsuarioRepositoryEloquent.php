<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use LaravelMetronic\Models\AuxTipoUsuario;

/**
 * Class AuxTipoUsuarioRepositoryEloquent
 * @package namespace LaravelMetronic\Repositories;
 */
class AuxTipoUsuarioRepositoryEloquent extends BaseRepository implements AuxTipoUsuarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AuxTipoUsuario::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
