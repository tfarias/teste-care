<?php

use Illuminate\Database\Seeder;

class TipoRotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            'Dashboard',
            'Auxiliares',
            'Cadastros',
            'Permissoes',
            'Usuário',
            'Tipo de usuário',
            'Sistema',
        ];

        foreach ($tipos as $descricao)
        {
            $dados = ['descricao' => $descricao,'icone'=>'icone'];
            $achou = \LaravelMetronic\Models\TipoRota::where('descricao', $descricao)->first();
            if (!$achou)
            {
                \LaravelMetronic\Models\TipoRota::create($dados);
            } else
            {
                $achou->update($dados);
            }
        }
    }
}
