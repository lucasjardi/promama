<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Termo;

class TermosController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$termos = Termo::first();
        return view('termo.formulario',['termos' => $termos]);
    }

    public function atualizar(Request $request)
    {
    	$termos = Termo::first();
        $termos->update($request->all());

        \Session::flash('mensagem_sucesso', 'Termos de Uso atualizado com sucesso!');

        return \Redirect::to('termos');
    }

    public function get()
    {
    	$termos = Termo::first();
        return view('termo.termo',['termos' => $termos]);
    }
}
