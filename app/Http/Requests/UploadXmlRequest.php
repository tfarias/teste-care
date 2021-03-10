<?php

namespace LaravelMetronic\Http\Requests;

class UploadXmlRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'path' => 'required',
        ];
        $path = $this->file('path');
        dd($path);


        return $rules;
    }


    public function messages()
    {
         return [
                'caminho.image' => 'O formato das imagens deve ser jpeg,bmp ou png!',
                'caminho.max' => 'O tamanho máximo da imagem deve ser 2000 KB!',
                'assinatura_id.required' => 'Assinatura é obrigatório',
                'assinatura_id.integer' => 'Assinatura inválido',
                'assinatura_id.exists' => 'Assinatura não exite na Base de Dados',
             ];
    }
}
