<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
            'nome'                 => 'Administrador',
            'senha'                => '12345',
            'email'                => 'adm@gmail.com',
            'telefone'             => '67999999999',
            'id_tipo_usuario' => '1'
        ];

        $usuario = \LaravelMetronic\Models\SisUsuario::where('email', $dados['email'])->first();
        if (!$usuario)
        {
            \LaravelMetronic\Models\SisUsuario::create($dados);
        } else
        {
            $usuario->update($dados);
        }
    }
}
