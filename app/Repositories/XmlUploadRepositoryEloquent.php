<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use LaravelMetronic\Models\XmlUpload;

/**
 * Class XmlUploadRepositoryEloquent
 * @package namespace LaravelMetronic\Repositories;
 */
class XmlUploadRepositoryEloquent extends BaseRepository implements XmlUploadRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return XmlUpload::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function sincronizar_pessoas($attributes, $id)
    {
        $model = parent::update($attributes, $id);
        $model->pessoas()->sync($attributes['pessoas']);
        return $model;
    }

    public function sincronizar_produtos($attributes, $id)
    {
        $model = parent::update($attributes, $id);
        $model->produtos()->sync($attributes['produtos']);
        return $model;
    }


}
