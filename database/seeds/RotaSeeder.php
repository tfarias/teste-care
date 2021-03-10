<?php

use Illuminate\Database\Seeder;

class RotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = \Illuminate\Support\Facades\File::get(base_path('database/seeds/data/permissoes.json'));
        $permissoes = json_decode($json, true);
        \Illuminate\Support\Facades\Cache::forget('rotas');

        foreach ($permissoes as $permissao)
        {
            $tipo = \LaravelMetronic\Models\TipoRota::where('descricao', $permissao['tipo'])->first();
            if (!$tipo)
            {
                dd('O tipo da rota (' . $permissao['tipo'] . ') não existe no banco.');
            }

            $permissao['id_tipo_rota'] = $tipo->id;
            unset($permissao['tipo']);
            $achou = \LaravelMetronic\Models\Rota::where('slug', $permissao['slug'])->first();
            if (!$achou)
            {
                \LaravelMetronic\Models\Rota::create($permissao);
            } else
            {
                $achou->update($permissao);
            }
        }
    }
}
