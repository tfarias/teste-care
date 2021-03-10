<?php

namespace LaravelMetronic\Services\Crud;

use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Config;
use Illuminate\Container\Container;

class CriaForms
{

    protected $template = 'app/Console/Commands/CreateCrud/forms.txt';

    /**
     * Cria o model do CRUD.
     *
     * @param string $tabela
     * @param string $campos
     */
    public function criar($tabela)
    {

        //TODO alterar o crud mapear bancos de dados
        //$banco = env('DB_CONNECTION', 'mysql');
        $schema = new Schema($tabela);
        $campos = $schema->getTableSchema();

        // Nome da classe em CamelCase
        $classe = ucfirst(Str::camel($tabela));
        $inputs ="";
        if (!empty($campos) ) {
            $request = File::get(base_path($this->template));

                foreach ($campos as $c) {
                    $c =  (object)$c;
                    if($c->Key=='PRI') {
                        continue;
                    }
                    if($c->Field=='created_at' || $c->Field=='updated_at' || $c->Field=='deleted_at'){
                        continue;
                    }
                    $passou = 0;
                    $aux = "";

                    $referencia = $schema->getTableReference($c->Field);

                    if($c->Null == 'NO') {
                        $aux .= "required";
                        $passou=1;
                    }else{
                        $passou=1;
                        $aux.="nullable";
                    }

                    if($c->Key == 'UNI') {
                        if($passou==1)
                            $aux .= "|unique:{$tabela},{$c->Field}";
                        else{
                            $aux .= "unique:{$tabela},{$c->Field}";
                        }
                        $passou =1;
                    }

                    if($c->Key == 'MUL') {
                        if(!empty($referencia)){
                            if($passou==1)
                                $aux .= "|integer|exists:{$referencia[0]->reftable},id";
                            else{
                                $aux .= "integer|exists:{$referencia[0]->reftable},id";
                            }
                        }
                        $passou =1;
                    }

                    if(!empty($referencia)) {
                        $tab = ucfirst(Str::camel($referencia[0]->reftable));
                        $inputs .= $schema->nlt(1);
                        $inputs .= $schema->nlt(1) . '$this->add("' . $c->Field . '","entity",[';
                        $inputs .= $schema->nlt(1) . '"class"=>\\' . Container::getInstance()->getNamespace() . 'Models\\' . $tab . '::class,';
                        $inputs .= $schema->nlt(1).'"property"=>"'.$schema->get_property().'",';
                        $inputs .= $schema->nlt(1).'"label"=>"'. ucfirst($c->Field).'",';
                        $inputs .= $schema->nlt(1).'"empty_value"=>"Selecione",';

                        if ($c->Key == 'MUL') {
//                            $inputs .= $schema->nlt(1).'"multiple"=>true,';
//                            $inputs .= $schema->nlt(1).'"attr"=>["name"=>"'.$c->Field.'[]"],';

                        }
                        if($passou==1){
                            $inputs .= $schema->nlt(1).'"rules" => "'.$aux.'",';
                        }
                        $inputs .= $schema->nlt(1).'"wrapper" => ["class" => "form-group col-md-6"]';

                        $inputs .= $schema->nlt(1).']);';

                    }else{
                        if(strripos($c->Type, 'text')){
                            $inputs .= $schema->nlt(1) . '$this->add("' . $c->Field . '","textarea",[';
                        }elseif(strripos($c->Type, 'tinyint')){
                            $inputs .= $schema->nlt(1) . '$this->add("' . $c->Field . '","checkbox",[';
                        }else{
                            $inputs .= $schema->nlt(1) . '$this->add("' . $c->Field . '","text",[';
                        }
                            $inputs .= $schema->nlt(1).'"label"=>"'. ucfirst($c->Field).'",';

                        if($passou==1){
                            $inputs .= $schema->nlt(1).'"rules" => "'.$aux.'",';
                        }
                            $inputs .= $schema->nlt(1).'"wrapper" => ["class" => "form-group col-md-6"]';
                            $inputs .= $schema->nlt(1).']);';
                    }

                }



            $request = str_replace('[{campos}]', $inputs, $request);
            $request = str_replace('[{namespace}]', Container::getInstance()->getNamespace(), $request);
            $request = str_replace('[{tabela_model}]', $classe, $request);
            File::put(base_path('app/Forms/' . $classe . 'Form.php'), $request);
        }


    }

}