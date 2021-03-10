<?php

namespace LaravelMetronic\Http\Controllers;

use LaravelMetronic\Models\Produtos;
use LaravelMetronic\Repositories\ProdutosRepository;
use LaravelMetronic\Relatorios\ProdutosListagem;
use LaravelMetronic\Forms\ProdutosForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{

    private $listagem;
    private $repository;

    public function __construct(ProdutosRepository $repository, ProdutosListagem $listagem)
    {
        $this->listagem = $listagem;
        $this->repository = $repository;

    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }
        $dados = $this->listagem->gerar($filtros);
        return view('produtos.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(ProdutosForm::class,[
            'url'=>route('produtos.create.post'),
            'method'=>'POST'
        ]);

        return view('produtos.create',compact('form'));

    }


   /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
          /** @var Form $form */
          $form = \FormBuilder::create(ProdutosForm::class);
          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }
          $data = $form->getFieldValues();
          $this->repository->create($data);

            flash('Produtos criado com sucesso!', 'success');

          return redirect()->route('produtos.index');
      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\Produtos $produtos
        * @return \Illuminate\Http\Response
        */
       public function edit(Produtos $produtos)
       {
           $form = \FormBuilder::create(ProdutosForm::class,[
               'url'=>route('produtos.edit.post',['produtos' => $produtos->id]),
               'method'=>'PUT',
               'model' => $produtos
           ]);

           return view('produtos.edit',compact('form'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $produtos
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Produtos $produtos)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(ProdutosForm::class,[
                'data' => ['id' => $produtos->id],
                'model' => $produtos
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $this->repository->update($data,$produtos->id);
            flash('Produtos alterado com sucesso!!', 'success');
            return redirect()->route('produtos.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\Produtos $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Produtos deletado com sucesso!!', 'success');

             return redirect()->route('produtos.index');
        }

    /**
     * Filtra um registro para os campos select2.
     *
     * @param
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fill()
    {
        $request = request()->all();

        $termo = $request['termo'];
        $size = $request['size'];
        $page = (!isset($request['page']) || $request['page'] < 1) ? 1 : $request['page'];

        if (!isset($termo))
            $termo = '';
        if (!isset($size) || $size < 1)
            $size = 10;

        $find = Produtos::where('descricao','like','%' . $termo . '%');
	    if(!empty($request['campo'])){
            $find->where($request['campo'],'=',$request['auxiliar']);
        }
        $count = $find->count();
        $ret["more"] = (($size * ($page - 1)) >= (int)$count) ? false : true;
        $ret["total"] = $count;
        $ret["dados"] = array();
        $find->limit($size);
        $find->offset($size * ($page - 1));
        $find->orderBy('descricao','asc');
        $result = $find->get();
        foreach ($result as $d) {
            $ret["dados"][] = array('id' => $d->id, 'text' => $d->descricao);
        }
        return response()->json($ret);
    }

     /**
         * Filtra um registro pelo id para atualizar os campos select2.
         *
         * @param int @id
         *
         * @return \Illuminate\Http\RedirectResponse
     */
     public function getedit($id)
     {
        $produtos = Produtos::find($id);
         $res = ['descicao'=>'selecione','id'=>null];
           if(!empty($produtos)){
             $res = ['descricao'=>$produtos->descricao,'id'=>$produtos->id];
           }
           return response()->json($res);
     }
}
