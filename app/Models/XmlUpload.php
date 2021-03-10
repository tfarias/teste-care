<?php

namespace LaravelMetronic\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Bootstrapper\Interfaces\TableInterface;

class XmlUpload extends BaseModel implements TableInterface
{
    use SoftDeletes;

    protected $fillable = ['path', 'cuf', 'cnf', 'natop', 'mod', 'serie', 'numero_nota', 'data_nota', 'valor_total'];

    protected $table = 'xml_upload';
    protected $dates = ['deleted_at','data_nota'];


    public function getTableHeaders()
    {
        return ['CUF', 'CNF', 'NATOP', 'MOD', 'Série', 'Número', 'Data', 'Valor'];
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
        switch ($header) {

            case "CUF":
                return $this->cuf;

            case "CNF":
                return $this->cnf;

            case "NATOP":
                return $this->natop;

            case "MOD":
                return $this->mod;

            case "Série":
                return $this->serie;

            case "Número":
                return $this->numero_nota;

            case "Data":
                return $this->data_nota->format('d/m/Y H:i:s');

            case "Valor":
                return $this->valor_total;
        }
    }


    /**
     * Xml_upload possui Nota_pessoas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function nota_pessoas()
    {
        return $this->hasMany(\LaravelMetronic\Models\NotaPessoas::class, 'id_nota', 'id');
    }

    /**
     * Xml_upload possui Nota_produtos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function nota_produtos()
    {
        return $this->hasMany(\LaravelMetronic\Models\NotaProdutos::class, 'id_nota', 'id');
    }


    function pessoas(){
        return $this->belongsToMany(\LaravelMetronic\Models\Pessoas::class,'nota_pessoas','id_nota','id_pessoa')->withPivot(['tipo'])->withTimestamps();
    }
    function produtos(){
        return $this->belongsToMany(\LaravelMetronic\Models\Produtos::class,'nota_produtos','id_nota','id_produto')->withPivot(['valor','quantidade'])->withTimestamps();
    }
}
