<?php

namespace LaravelMetronic\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Bootstrapper\Interfaces\TableInterface;

class NotaProdutos extends BaseModel implements TableInterface
{
    use SoftDeletes;

    protected $fillable = ['id_nota', 'id_produto', 'valor', 'quantidade'];

    protected $table = 'nota_produtos';
    protected $dates = ['deleted_at'];


    public function getTableHeaders()
    {
        return ['Id_nota', 'Id_produto', 'Valor', 'Quantidade', 'Valor_icms', 'Valor_pis', 'Valor_cofins', 'Valor_imposto'];
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

            case "Id_nota":
                return $this->id_nota;

            case "Id_produto":
                return $this->id_produto;

            case "Valor":
                return $this->valor;

            case "Quantidade":
                return $this->quantidade;

        }
    }


    /**
     * Nota_produtos pertence a Xml_upload
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function Xml_upload()
    {
        return $this->belongsTo(\LaravelMetronic\Models\XmlUpload::class, 'id_nota', 'id');
    }

    /**
     * Nota_produtos pertence a Produtos
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    function Produtos()
    {
        return $this->belongsTo(\LaravelMetronic\Models\Produtos::class, 'id_produto', 'id');
    }
}
