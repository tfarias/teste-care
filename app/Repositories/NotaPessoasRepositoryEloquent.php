<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use LaravelMetronic\Models\NotaPessoas;

/**
 * Class NotaPessoasRepositoryEloquent
 * @package namespace LaravelMetronic\Repositories;
 */
class NotaPessoasRepositoryEloquent extends BaseRepository implements NotaPessoasRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NotaPessoas::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
