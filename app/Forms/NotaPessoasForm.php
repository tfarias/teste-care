<?php

namespace LaravelMetronic\Forms;

use Bootstrapper\Facades\Icon;
use Kris\LaravelFormBuilder\Form;

class NotaPessoasForm extends Form
{
    public function buildForm()
    {
        
    
    $this->add("id_nota","entity",[
    "class"=>\LaravelMetronic\Models\XmlUpload::class,
    "property"=>"id",
    "label"=>"Id_nota",
    "empty_value"=>"Selecione",
    "rules" => "required|integer|exists:xml_upload,id",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    
    $this->add("id_pessoa","entity",[
    "class"=>\LaravelMetronic\Models\Pessoas::class,
    "property"=>"id",
    "label"=>"Id_pessoa",
    "empty_value"=>"Selecione",
    "rules" => "required|integer|exists:pessoas,id",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("tipo","text",[
    "label"=>"Tipo",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
        $this
           ->add('submit', 'submit', ['label' =>  Icon::create('pencil').' Salvar','attr'=>['class'=>'btn btn-primary btn-send-form pull-left']])
           ->add('clear', 'reset', ['label' => Icon::create('refresh').' Limpar','attr'=>['class'=>'btn btn-danger pull-left']]);
    }
}
