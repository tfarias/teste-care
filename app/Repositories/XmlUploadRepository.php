<?php

namespace LaravelMetronic\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface XmlUploadRepository
 * @package namespace LaravelMetronic\Repositories;
 */
interface XmlUploadRepository extends RepositoryInterface
{
    public function sincronizar_pessoas($attributes, $id);
    public function sincronizar_produtos($attributes, $id);
}
