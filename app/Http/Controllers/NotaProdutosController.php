<?php

namespace LaravelMetronic\Http\Controllers;

use LaravelMetronic\Models\NotaProdutos;
use LaravelMetronic\Repositories\NotaProdutosRepository;
use LaravelMetronic\Relatorios\NotaProdutosListagem;
use LaravelMetronic\Forms\NotaProdutosForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

class NotaProdutosController extends Controller
{

    private $listagem;
    private $repository;

    public function __construct(NotaProdutosRepository $repository, NotaProdutosListagem $listagem)
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
        return view('nota_produtos.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(NotaProdutosForm::class,[
            'url'=>route('nota_produtos.create.post'),
            'method'=>'POST'
        ]);

        return view('nota_produtos.create',compact('form'));

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
          $form = \FormBuilder::create(NotaProdutosForm::class);
          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }
          $data = $form->getFieldValues();
          $this->repository->create($data);

            flash('Nota Produtos criado com sucesso!', 'success');

          return redirect()->route('nota_produtos.index');
      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\NotaProdutos $nota_produtos
        * @return \Illuminate\Http\Response
        */
       public function edit(NotaProdutos $nota_produtos)
       {
           $form = \FormBuilder::create(NotaProdutosForm::class,[
               'url'=>route('nota_produtos.edit.post',['nota_produtos' => $nota_produtos->id]),
               'method'=>'PUT',
               'model' => $nota_produtos
           ]);

           return view('nota_produtos.edit',compact('form'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $nota_produtos
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, NotaProdutos $nota_produtos)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(NotaProdutosForm::class,[
                'data' => ['id' => $nota_produtos->id],
                'model' => $nota_produtos
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $this->repository->update($data,$nota_produtos->id);
            flash('Nota Produtos alterado com sucesso!!', 'success');
            return redirect()->route('nota_produtos.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\NotaProdutos $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Nota Produtos deletado com sucesso!!', 'success');

             return redirect()->route('nota_produtos.index');
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

        $find = NotaProdutos::where('descricao','like','%' . $termo . '%');
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
        $nota_produtos = NotaProdutos::find($id);
         $res = ['descicao'=>'selecione','id'=>null];
           if(!empty($nota_produtos)){
             $res = ['descricao'=>$nota_produtos->descricao,'id'=>$nota_produtos->id];
           }
           return response()->json($res);
     }
}
