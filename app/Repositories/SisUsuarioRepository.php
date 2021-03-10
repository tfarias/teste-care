<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SisUsuarioRepository
 * @package namespace LaravelMetronic\Repositories;
 */
interface SisUsuarioRepository extends RepositoryInterface
{
    public function usuario_area_sincronizar($attributes, $id);
    public function usuario_ciclo_sincronizar($attributes, $id);
    public function usuario_municipio_sincronizar($attributes, $id);

}
