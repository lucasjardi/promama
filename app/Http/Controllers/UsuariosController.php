<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsuariosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
    	$users = User::whereNotNull('api_token')->where('name','!=','admin')->get();
    	return view('usuarios.listar', ['usuarios' => $users, 'count' => count($users)]);
    }
}
