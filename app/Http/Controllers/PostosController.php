<?php

namespace App\Http\Controllers;

use App\Bairro;
use App\Posto;
use Illuminate\Http\Request;

class PostosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $postos = Posto::paginate(5);
        $postos = Posto::orderBy('posto_nome')->get();
        return view('postos.listar', ['postos' => $postos]);
    }

    public function novo()
    {
        $bairros = Bairro::all();

        $bairrosNome = array();
        foreach ($bairros as $bairro){
            $bairrosNome[ $bairro->bairro_id ] = $bairro->bairro_nome;
        }

        return view('postos.formulario', ['bairros' => $bairrosNome]);
    }

    public function salvar(Request $request)
    {
        Posto::create($request->all());

        \Session::flash('mensagem_sucesso', 'Posto cadastrado com sucesso!');

        return \Redirect::to('postos/novo');
    }

    public function editar($id)
    {
        $posto = Posto::findOrFail($id);

        $bairros = Bairro::all();

        $bairrosNome = array();
        foreach ($bairros as $bairro){
            $bairrosNome[ $bairro->bairro_id ] = $bairro->bairro_nome;
        }

        return view('postos.formulario', ['posto' => $posto, 'bairros' => $bairrosNome]);

    }

    public function atualizar($id, Request $request)
    {
        $posto = Bairro::findOrFail($id);

        $posto->update($request->all());

        \Session::flash('mensagem_sucesso', 'Bairro atualizado com sucesso!');

        return \Redirect::to('postos/'.$posto->posto_id.'/editar');
    }

    public function deletar($id)
    {
        $posto = Posto::findOrFail($id);

        $posto->delete();

        \Session::flash('mensagem_sucesso', 'Posto excluído com sucesso!');

        return \Redirect::to('postos');
    }
}
