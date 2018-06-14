<?php

namespace App\Http\Controllers;

use App\Duvida;
use Illuminate\Http\Request;

class DuvidasController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $duvidas = Duvida::with('usuario')->whereNull('resposta')->get();

        return view('duvidas.listar',['duvidas' => $duvidas]);
    }

    public function read($duvidaId)
    {
        $duvida = Duvida::with('usuario')->findOrFail($duvidaId);
        // $respostaDaDuvida = Resposta::where('resposta_duvida', "=", "$duvidaId")->first();

        // return view('duvidas.duvida',['duvida' => $duvida, 'resposta' => $respostaDaDuvida]);
        return view('duvidas.duvida',['duvida' => $duvida]);
    }

    public function atualizar(Request $request,$duvidaId)
    {
        if($request->paraTodos === "on" ) $request->paraTodos = 1;
        else $request->paraTodos = 0;

        $duvida = Duvida::findOrFail($duvidaId);
        $duvida->resposta = $request->resposta;
        $duvida->paraTodos = $request->paraTodos;
        $duvida->update();

        \Session::flash('mensagem_sucesso', 'Dúvida atualizada com sucesso!');

        return \Redirect::to('/duvidas/respondidas');

    }

    public function responderDuvida(Request $request)
    {
        if($request->paraTodos === "on" ) $request->paraTodos = 1;
        else $request->paraTodos = 0;

        $duvida = Duvida::find($request->id);
        $duvida->resposta = $request->resposta;
        $duvida->paraTodos = $request->paraTodos;
        $duvida->update();

        \Session::flash('mensagem_sucesso', 'Dúvida respondida com sucesso!');

        return \Redirect::to('/duvidas'); // fazer retornar para lista de duvidas
    }

    public function renderizaRespondidas()
    {
        $duvidas = Duvida::with('usuario')->whereNotNull('resposta')->get();

        return view('duvidas.listar', ['duvidas' => $duvidas, 'respondidas' => true]);
    }

    public function deletar($id)
    {
        $duvida = Duvida::findOrFail($id);

        $duvida->delete();

        \Session::flash('mensagem_sucesso', 'Dúvida excluída com sucesso!');

        return \Redirect::to('duvidas');
    }
}
