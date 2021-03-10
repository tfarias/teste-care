<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use LaravelMetronic\Models\NotaProdutos;

/**
 * Class NotaProdutosRepositoryEloquent
 * @package namespace LaravelMetronic\Repositories;
 */
class NotaProdutosRepositoryEloquent extends BaseRepository implements NotaProdutosRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NotaProdutos::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
