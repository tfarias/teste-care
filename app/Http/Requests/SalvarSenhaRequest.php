<?php

namespace LaravelMetronic\Http\Requests;

class SalvarSenhaRequest extends Request
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
        $userId = $this->route('id');

        return [
                'senha' => 'required|string|min:6|confirmed',
             ];
    }


    public function messages()
    {
         return [
             'senha.min'=>'A senha deve ter no mínimo 6 caracteres',
             'senha.confirmed' =>'As senhas não são iguais'
             ];
    }
}
