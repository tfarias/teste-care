<?php

namespace LaravelMetronic\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Bootstrapper\Interfaces\TableInterface;

class Pessoas extends BaseModel implements TableInterface
{
    use SoftDeletes;

    protected $fillable = ['nome', 'nome_fantasia', 'cpf_cnpj', 'logradouro', 'numero', 'bairro', 'cod_municipio', 'municipio', 'uf', 'cep', 'codigo_pais', 'inscricao_estadual', 'inscricao_municipal', 'crt', 'email', 'complemento'];

    protected $table = 'pessoas';
    protected $dates = ['deleted_at'];


    public function getTableHeaders()
    {
        return ['Nome', 'Nome_fantasia', 'Cpf_cnpj', 'Logradouro', 'Numero', 'Bairro', 'Cod_municipio', 'Municipio', 'Uf', 'Cep', 'Codigo_pais', 'Inscricao_estadual', 'Inscricao_municipal', 'Crt', 'Email'];
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
            case "Nome":
                return $this->nome;

            case "Nome_fantasia":
                return $this->nome_fantasia;

            case "Cpf_cnpj":
                return $this->cpf_cnpj;

            case "Logradouro":
                return $this->logradouro;

            case "Numero":
                return $this->numero;

                case "Bairro":
                return $this->bairro;

            case "Cod_municipio":
                return $this->cod_municipio;

            case "Municipio":
                return $this->municipio;

            case "Uf":
                return $this->uf;

            case "Cep":
                return $this->cep;

            case "Codigo_pais":
                return $this->codigo_pais;

            case "Inscricao_estadual":
                return $this->inscricao_estadual;

            case "Inscricao_municipal":
                return $this->inscricao_municipal;

            case "Crt":
                return $this->crt;

            case "Email":
                return $this->email;
        }
    }


    /**
     * Pessoas possui Nota_pessoas
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    function Nota_pessoas()
    {
        return $this->hasMany(\LaravelMetronic\Models\NotaPessoas::class, 'id_pessoa', 'id');
    }
}
