<?php

namespace App\Http\Controllers;

use App\Bairro;
use Illuminate\Http\Request;

class BairrosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $bairros = Bairro::paginate(5);
        $bairros = Bairro::orderBy('bairro_nome')->get();
        return view('bairros.listar',['bairros' => $bairros]);
    }

    public function novo()
    {
        return view('bairros.formulario');
    }

    public function salvar(Request $request)
    {
        Bairro::create($request->all());

        \Session::flash('mensagem_sucesso', 'Bairro cadastrado com sucesso!');

        return \Redirect::to('bairros/novo');
    }

    public function editar($id)
    {
        $bairro = Bairro::findOrFail($id);

        return view('bairros.formulario', ['bairro' => $bairro]);

    }

    public function atualizar($id, Request $request)
    {
        $bairro = Bairro::findOrFail($id);

        $bairro->update($request->all());

        \Session::flash('mensagem_sucesso', 'Bairro atualizado com sucesso!');

        return \Redirect::to('bairros/'.$bairro->bairro_id.'/editar');
    }

    public function deletar($id)
    {
        $bairro = Bairro::findOrFail($id);

        $bairro->delete();

        \Session::flash('mensagem_sucesso', 'Bairro excluído com sucesso!');

        return \Redirect::to('bairros');
    }

    public function pesquisar(Request $request)
    {
        $request->validate([
            'search' => 'required'
        ]);

        $data = Bairro::where('bairro_nome','LIKE',"%{$request->search}%")->orderBy('bairro_nome','asc')->get();

        return view('bairros.listar', ['bairros' => $data]);
    }
}
