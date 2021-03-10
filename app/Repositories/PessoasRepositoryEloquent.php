<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use LaravelMetronic\Models\Pessoas;

/**
 * Class PessoasRepositoryEloquent
 * @package namespace LaravelMetronic\Repositories;
 */
class PessoasRepositoryEloquent extends BaseRepository implements PessoasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pessoas::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
