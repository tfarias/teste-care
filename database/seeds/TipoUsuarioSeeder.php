<?php

use Illuminate\Database\Seeder;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'id'          => '1',
                'descricao'   => 'Desenvolvedor',
                'super_admin' => 'S',
            ],
            [
                'id'          => '2',
                'descricao'   => 'Suporte',
                'super_admin' => 'N',
            ],

        ];

        foreach ($tipos as $dados)
        {
            $tipo = \LaravelMetronic\Models\AuxTipoUsuario::find($dados['id']);
            if (!$tipo)
            {
                \LaravelMetronic\Models\AuxTipoUsuario::create($dados);
            } else
            {
                $tipo->update($dados);
            }
        }
    }
}
