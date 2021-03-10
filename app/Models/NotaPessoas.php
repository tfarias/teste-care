<?php

namespace LaravelMetronic\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Bootstrapper\Interfaces\TableInterface;

class NotaPessoas extends BaseModel implements TableInterface
{
  use SoftDeletes;
    protected $fillable = ['id_nota','id_pessoa','tipo'];

    protected $table = 'nota_pessoas';
    protected $dates = ['deleted_at'];


     public function getTableHeaders()
        {
            return ['Id_nota','Id_pessoa','Tipo'];
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
            
    
    case "Id_nota":
    return $this->id_nota;
    
    case "Id_pessoa":
    return $this->id_pessoa;
    
    case "Tipo":
    return $this->tipo;
        }
    }

    
    /**
    * Nota_pessoas pertence a Xml_upload
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
    */
    function Xml_upload() {
        return $this->belongsTo(\LaravelMetronic\Models\XmlUpload::class,'id_nota','id');
    }
    /**
    * Nota_pessoas pertence a Pessoas
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
    */
    function Pessoas() {
        return $this->belongsTo(\LaravelMetronic\Models\Pessoas::class,'id_pessoa','id');
    }
}
