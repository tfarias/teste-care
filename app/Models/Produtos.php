<?php

namespace LaravelMetronic\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Bootstrapper\Interfaces\TableInterface;

class Produtos extends BaseModel implements TableInterface
{
  use SoftDeletes;
    protected $fillable = ['codigo_produto','descricao'];

    protected $table = 'produtos';
    protected $dates = ['deleted_at'];


     public function getTableHeaders()
        {
            return ['Codigo_produto','Descricao'];
        }

 /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch ($header){
            
    
    case "Codigo_produto":
    return $this->codigo_produto;
    
    case "Descricao":
    return $this->descricao;
        }
    }

    
    
    /**
    * Produtos possui Nota_produtos
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    function Nota_produtos() {
        return $this->hasMany(\LaravelMetronic\Models\NotaProdutos::class,'id_produto','id');
    }
}
