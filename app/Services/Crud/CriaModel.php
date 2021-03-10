<?php

namespace LaravelMetronic\Services\Crud;

use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Container\Container;
class CriaModel
{

    protected $template = 'app/Console/Commands/CreateCrud/model.txt';
    protected $tabela;
    protected $dbschema;
    /**
     * Cria o model do CRUD.
     *
     * @param string $tabela
     */

    protected function getAppNamespace()
    {
        return Container::getInstance()->getNamespace();
    }

    public function criar($tabela)
    {
        $this->tabela = $tabela;
        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));

        $model = File::get(base_path($this->template));
        $model = str_replace('[{tabela}]', $tabela, $model);
        $model = str_replace('[{tabela_model}]', $classe, $model);

        $funcoes = "";
        $schema = new Schema($tabela);
        $dbschema = $schema->getDbSchema();
        $table =  $schema->getTableSchema();

        $fillable = [];
        $fields = [];
        $table_value = "";

        if (!empty($table)) {
            foreach ($table as $c) {
                $c =  (object)$c;

                if($c->Key=='PRI' || $c->Field=='created_at' || $c->Field=='updated_at' || $c->Field=='deleted_at'){
                    continue;
                }

                $fillable[] = "'".$c->Field."'";

                if( $c->Field=='senha'){
                    continue;
                }

                $fields[] = "'".ucfirst($c->Field)."'";
                $table_value.=$schema->nlt(1);
                $table_value.=$schema->nlt(1).'case "'.ucfirst($c->Field).'":';
                $table_value.=$schema->nlt(1).'return $this->'.$c->Field.';';
            }
        }


        $model = str_replace('[{fillable}]', implode(',',$fillable), $model);
        $model = str_replace('[{table_header}]', implode(',',$fields), $model);
        $model = str_replace( '[{table_values}]', $table_value, $model);

        $used = array('1');

        foreach ($dbschema as $v) {
            if ($v->table == $tabela && $v->reftable != $tabela) {
                $mname = ucfirst(($v->reftable));
                $cused = 2;
                while (array_search($mname, $used))
                    $mname .= $cused;
                $used[] = $mname;
                $funcoes.= $schema->nlt(1) .'/**';
                $funcoes.= $schema->nlt(1) .'* ' . ucfirst($tabela) . ' pertence a ' . ucfirst($v->reftable);
                $funcoes.= $schema->nlt(1) . '* @return \Illuminate\Database\Eloquent\Relations\BelongsTo ';
                $funcoes.=  $schema->nlt(1) . '*/';
                $funcoes.=  $schema->nlt(1) . 'function ' . $mname . '() {';
                $funcoes.=  $schema->nlt(2) . 'return $this->belongsTo(\\'.$this->getAppNamespace().'Models\\' . ucfirst(Str::camel($v->reftable)) . '::class,\'' . $v->fk . '\',\'' . $v->refpk . '\');';
                $funcoes.=  $schema->nlt(1) . "}";
            }
            if ($v->reftable == $tabela && $v->table != $tabela ) {
                $mname =  $schema->getPlural(ucfirst(($v->table)));
                $cused = 2;
                while (array_search($mname, $used))
                    $mname .= $cused;
                $used[] = $mname;
                $funcoes.= $schema->nlt(1);
                $funcoes.= $schema->nlt(1) . '/**';
                $funcoes.=$schema->nlt(1) . '* ' . ucfirst($tabela) . ' possui ' . $schema->getPlural(ucfirst($v->table));
                $funcoes.=$schema->nlt(1) . '* @return \Illuminate\Database\Eloquent\Relations\HasMany';
                $funcoes.=$schema->nlt(1) . '*/';
                $funcoes.=$schema->nlt(1) . 'function ' . $mname . '() {';
                $funcoes.=$schema->nlt(2) . 'return $this->hasMany(\\'.$this->getAppNamespace().'Models\\' . ucfirst(Str::camel($v->table)) . '::class,\'' . $v->fk . '\',\'' . $v->refpk . '\');';
                $funcoes.=$schema->nlt(1) . "}";
            }
        }
        $model = str_replace('[{funcoes}]', $funcoes, $model);
        $model = str_replace('[{namespace}]', $this->getAppNamespace(), $model);


        File::put(base_path('app/Models/' . $classe . '.php'), $model);

    }




}