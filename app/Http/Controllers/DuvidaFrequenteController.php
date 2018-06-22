<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DuvidaFrequente;

class DuvidaFrequenteController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $duvidasfrequentes = DuvidaFrequente::paginate(5);
        $duvidasfrequentes = DuvidaFrequente::orderBy('updated_at',false)->orderBy('created_at',false)->get();
        return view('duvidasfrequentes.listar',['duvidasfrequentes' => $duvidasfrequentes]);
    }

    public function novo()
    {
        return view('duvidasfrequentes.formulario');
    }

    public function salvar(Request $request)
    {
        DuvidaFrequente::create($request->all());

        \Session::flash('mensagem_sucesso', 'Duvida cadastrado com sucesso!');

        return \Redirect::to('duvidas-frequentes/novo');
    }

    public function editar($id)
    {
        $duvidafrequente = DuvidaFrequente::findOrFail($id);

        return view('duvidasfrequentes.formulario', ['df' => $duvidafrequente]);

    }

    public function atualizar($id, Request $request)
    {
        $duvidafrequente = DuvidaFrequente::findOrFail($id);

        $duvidafrequente->update($request->all());

        \Session::flash('mensagem_sucesso', 'Duvida atualizado com sucesso!');

        return \Redirect::to('duvidas-frequentes/'.$duvidafrequente->id.'/editar');
    }

    public function deletar($id)
    {
        $duvidafrequente = DuvidaFrequente::findOrFail($id);

        $duvidafrequente->delete();

        \Session::flash('mensagem_sucesso', 'Duvida excluído com sucesso!');

        return \Redirect::to('duvidas-frequentes');
    }

}
