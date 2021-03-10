<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use LaravelMetronic\Models\SisUsuario;

/**
 * Class SisUsuarioRepositoryEloquent
 * @package namespace LaravelMetronic\Repositories;
 */
class SisUsuarioRepositoryEloquent extends BaseRepository implements SisUsuarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SisUsuario::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function usuario_area_sincronizar($attributes, $id)
    {
        $model = parent::update($attributes, $id);
        if(isset($attributes['area'])){
            $model->areas()->sync($attributes['area']);
        }
        return $model;
    }

    public function usuario_ciclo_sincronizar($attributes, $id)
    {
        $model = parent::update($attributes, $id);
        if(isset($attributes['ciclo'])){
            $res =[];
            foreach ($attributes['ciclo'] as $m) {
                $res[$m] = ['quant_imovel'=>$attributes['quant_imovel']];
            }
            $model->ciclos()->sync($res);
        }
        return $model;
    }

    public function usuario_municipio_sincronizar($attributes, $id)
    {
        $model = parent::update($attributes, $id);
        if(isset($attributes['municipio'])){
            $res =[];
            foreach ($attributes['municipio'] as $m) {
                $res[$m] = ['data_saida'=>$attributes['data_saida']];
            }
            $model->municipios()->sync($res);
        }
        return $model;
    }
}
