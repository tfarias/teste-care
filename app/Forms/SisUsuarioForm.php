<?php

namespace LaravelMetronic\Forms;

use Bootstrapper\Facades\Icon;
use Kris\LaravelFormBuilder\Form;

class SisUsuarioForm extends Form
{
    public function buildForm()
    {

        $this->add("nome", "text", [
            "rules" => "required",
            'wrapper' => ['class' => 'form-group col-md-6'],
        ]);

        if(!$this->model){
            $this->add("senha", "text", [
                "rules" =>"required" ,
                'wrapper' => ['class' => 'form-group col-md-6'],
                "value" => ""
            ]);
        }
        
        $this->add("email", "text", [
            'wrapper' => ['class' => 'form-group col-md-6'],
            "rules" => "required|unique:sis_usuario,email". (empty($this->model) ? "" : ",{$this->model->id}"),
        ]);
        $this->add("telefone", "text", [
            'wrapper' => ['class' => 'form-group col-md-6'],
            "rules" => "nullable",
            "attr" => [
                "mask" =>"phone"
            ]
        ]);

        $this->add("id_tipo_usuario", "entity", [
            "class" => \LaravelMetronic\Models\AuxTipoUsuario::class,
            "label" => "Tipo usuário",
            "property" => "descricao",
            "rules" => "required|integer|exists:aux_tipo_usuario,id",
            'wrapper' => ['class' => 'form-group col-md-6 '],
        ]);

        $this
            ->add('submit', 'submit', ['label' =>  Icon::create('pencil').' Salvar','attr'=>['class'=>'btn btn-primary btn-send-form pull-left']])
            ->add('clear', 'reset', ['label' => Icon::create('refresh').' Limpar','attr'=>['class'=>'btn btn-danger pull-left']]);
    }
}
