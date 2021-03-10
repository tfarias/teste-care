<?php

namespace LaravelMetronic\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SisUsuario extends Authenticatable implements TableInterface
{
    use SoftDeletes;
    use Notifiable;

    protected $fillable = ['nome', 'senha', 'email', 'telefone', 'id_tipo_usuario'];

    protected $table = 'sis_usuario';

    protected $hidden = [
        'senha',
    ];

    protected $dates = ['deleted_at'];


    public function getTableHeaders()
    {
        return ['Nome', 'Email', 'Telefone', 'Tipo de usuário'];
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

            case "Email":
                return $this->email;

            case "Telefone":
                return $this->telefone;

            case "Tipo de usuário":
                return $this->tipo_usuario->descricao;

        }
    }


    /**
     * Verifica se o usuário tem permissão para acessar a determinada rota.
     *
     * @param Rota $rota
     *
     * @return bool
     */
    public function temPermissao($rota)
    {
        // Grupos que podem acessar essa rota
        $grupos = $rota->grupos->pluck('id')->toArray();

        return in_array($this->attributes['id_tipo_usuario'], $grupos);
    }

    /**
     * Retorna a senha do usuário.
     *
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->attributes['senha'];
    }

    /**
     * Retorna se algum dos grupos de acesso do usuário está marcado como super admin.
     *
     * @return bool
     */
    public function getSuperAdminAttribute()
    {
        return $this->tipo_usuario->super_admin == 'S';
    }

    /**
     * Obtém o primeiro nome do usuário
     *
     * @return string
     */
    public function getPrimeiroNomeAttribute()
    {
        return array_first(explode(' ', $this->attributes['nome']));
    }

     /**
     * Encripta a senha antes de salvar.
     *
     * @param string $senha
     */
    public function setSenhaAttribute($senha)
    {
        if (!is_null($senha) && !empty($senha)) {
            $this->attributes['senha'] = bcrypt($senha);
        }
    }

    public function tipo_usuario(){
        return $this->belongsTo(\LaravelMetronic\Models\AuxTipoUsuario::class,'id_tipo_usuario');
    }
   
}
