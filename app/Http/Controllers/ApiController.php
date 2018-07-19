<?php

namespace App\Http\Controllers;

use App\Mail\EsqueciASenha;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Bairro;
use App\Posto;
use App\User;
use App\Informacao;
use App\Crianca;
use App\Duvida;
use App\Resposta;
use App\Sincronizacao;
use App\Notificacao;
use App\Marco;
use App\Acompanhamento;
use App\Foto;
use Auth;
use Validator;

class ApiController extends Controller
{
    private $default_token = "token1";

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /* email */

    public function esqueciasenha(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'email',
        ]);

        if (! $validator->fails()) {

            $usuarioSolicitante = User::where('email', $request->email)->first();

            if ($usuarioSolicitante != null) {

                $senha_reserva = str_random(5);
                
                $usuarioSolicitante->senha_reserva = $senha_reserva;

                $usuarioSolicitante->update();

                Mail::to($request->email)->send(new EsqueciASenha($senha_reserva));

                return response()->json([
                    'success' => true,
                    'message' => $senha_reserva
                ]);

            } else {
                return response()->json([
                    'message' => 'Este e-mail não consta no nosso sistema.',
                ], 401);
            }

        } else {
            return response()->json([
                'message' => 'O e-mail é inválido.',
            ], 401);
        }

    }

    /* fim email */

    public function cadastrarUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'unique:users',
        ]);


        if ($validator->fails()) {

            //E-mail already exists

            return response()->json([
                'message' => 'Este e-mail ja existe.',
            ], 401);
        } else {

        	$usuario = new User($request->all());
        	$usuario->api_token = str_random(60);
            if($request->posto_saude == 0) $usuario->posto_saude = null;

            if($usuario->save()) {

                return response()->json([
                    'success' => true,
                    'message' => $usuario->api_token,
                    'id' => intval($usuario->id)
                ]);

            }
        }
    }

    public function editarUser($userID, Request $request)
    {
    	if ( $request->api_token !== $this->default_token ) {

    		$usuario = User::findOrFail($userID);
    		$request->merge(['data_nascimento' => substr($request->data_nascimento, 0,10)]);

	        if( $usuario->update($request->except('password')) ) {
	            return response()->json([
	                    'success' => true,
	                    'message' => 'success',
	                    'id' => intval($userID)
	                ]);
	        } else {
	            return response()->json([
	                    'message' => 'could not update',
	                ], 401);
	        }
	        
    	}
    }

    public function removerUser($userID)
    {
        $usuario = User::findOrFail($userID);

        if ( $usuario->delete() ) {
            return response()->json([
                    'success' => true,
                    'message' => 'success'
                ]);
        } else {
            return response()->json([
                    'success' => false,
                    'message' => 'could not delete',
                ], 401);
        }
    }
    

    public function login(Request $request)
    {
       $login = User::where('email',$request->email)
                     ->where('password',$request->password)
                     ->pluck('id')
                     ->first();


       if ( $login ) {

            $api_token = User::where('email',$request->email)->pluck('api_token')->first();

            return response()->json([
                'success' => true,
                'message' => $api_token,
                'id' => $login
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Usuário ou senha incorretos.',
            ], 401);
        }
        
    }

    public function uploadFoto(Request $request)
    {

     if($request->hasFile('foto')){

        $path = $request->file('foto')->store('fotos_criancas');

        $foto = new Foto([
            'crianca' => $request->crianca,
            'mes' => $request->mes,
            'url' => $path
        ]);

        if ( $foto->save() ) {

            return response()->json([
                'success' => true,
                'id' => intval($foto->id)
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Could not insert row in fotos'
            ], 401);
        }

     } else {
        return response()->json([
                'success' => false
            ], 401);
     }

    }

    public function getNotificacoes()
    {
        return Notificacao::get();
    }

    public function getSincronizacaoTable()
    {
    	return Sincronizacao::first();
    }

    public function getInformacoes()
    {
        return Informacao::with('links')->get();


    }

    public function getBairros()
    {
        return Bairro::get();
    }

    public function getPostos()
    {
    	return Posto::get();
    }

    public function cadastrarCrianca(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {
            
            $crianca = new Crianca($request->all());
            $crianca->crianca_dataNascimento = substr($crianca->crianca_dataNascimento, 0,10);
            $crianca->user_id = $request->user()->id;

            if( $crianca->save() ){

                return response()->json([
                        'success' => true,
                        'id' => intval($crianca->crianca_id)
                    ]);

            } else {
                return response()->json([
                        'success' => false,
                        'message' => 'could not save',
                    ], 401);
            }

        }
    }

    public function editarCrianca($criancaID, Request $request)
    {
    	if ( $request->api_token !== $this->default_token ) {

	        $crianca = Crianca::findOrFail($criancaID);
	        $request->merge(['crianca_dataNascimento' => substr($request->crianca_dataNascimento, 0,10)]);
	        
	        if( $crianca->update($request->all()) ) {
	            return response()->json([
	                    'success' => true,
	                    'message' => 'success',
	                    'id' => intval($criancaID)
	                ]);
	        } else {
	            return response()->json([
	                    'success' => false,
	                    'message' => 'could not update',
	                ], 401);
	        }

    	}
    }

    public function removerCrianca($criancaID)
    {
        $crianca = Crianca::findOrFail($criancaID);

        if ( $crianca->delete() ) {
            return response()->json([
                    'success' => true,
                    'message' => 'success'
                ]);
        } else {
            return response()->json([
                    'success' => false,
                    'message' => 'could not delete',
                ], 401);
        }
    }

    public function getCrianca($criancaID)
    {
        return Crianca::findOrFail($criancaID);
    }

    public function getCriancasByUserId($userID)
    {
        return Crianca::where('user_id',$userID)->get();
    }

    public function inserirFoto(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $foto = new Foto($request->all());

            if( $foto->save() ){

                return response()->json([
                        'success' => true,
                        'id' => intval($foto->id)
                    ]);

            } else {
                return response()->json([
                        'success' => false,
                        'message' => 'could not save',
                    ], 401);
            }

        }
    }

    public function updateFoto($fotoID, Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $foto = Foto::findOrFail($fotoID);
            
            if( $foto->update($request->all()) ) {
                return response()->json([
                        'success' => true,
                        'message' => 'success',
                        'id' => intval($fotoID)
                    ]);
            } else {
                return response()->json([
                        'success' => false,
                        'message' => 'could not update',
                    ], 401);
            }

        }
    }

    public function getFotosDaCriancaByUserId(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $criancas = Crianca::with('fotos')->where('user_id',$request->user()->id)->get();
            $fotosDaCrianca= array();

            foreach ($criancas as $crianca) {
                array_push($fotosDaCrianca, $crianca->fotos);
            }

            return $fotosDaCrianca;
        }

    }



    public function getMarcosByUserId(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $criancas = Crianca::with('marcos')->where('user_id',$request->user()->id)->get();
            $marcosArray= array();

            foreach ($criancas as $crianca) {
                array_push($marcosArray, $crianca->marcos);
            }

            return $marcosArray;
        }

    }

    public function editarMarco($marcoID, Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $marco = Marco::findOrFail($marcoID);
            // $request->merge(['data1' => substr($request->data1, 0,10)]);
            
            if( $marco->update($request->all()) ) {
                return response()->json([
                        'success' => true,
                        'message' => 'success',
                        'id' => intval($marcoID)
                    ]);
            } else {
                return response()->json([
                        'success' => false,
                        'message' => 'could not update',
                    ], 401);
            }

        }
    }


    public function cadastrarAcompanhamento(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {
            
            $acomp = new Acompanhamento($request->all());
            $acomp->data = substr($request->data, 0,10);

            if( $acomp->save() ){

                return response()->json([
                        'success' => true,
                        'id' => intval($acomp->id)
                    ]);

            } else {
                return response()->json([
                        'success' => false,
                        'message' => 'could not save',
                    ], 401);
            }

        }
    }

    public function getAcompanhamentosByUserId(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $criancas = Crianca::with('acompanhamentos')->where('user_id',$request->user()->id)->get();
            $acompanhamentos= array();

            foreach ($criancas as $crianca) {
                array_push($acompanhamentos, $crianca->acompanhamentos);
            }

            return $acompanhamentos;
        }

    }


    public function getUserById($userID)
    {
        return User::with('criancas')->where('id',$userID)->get()->first();
    }

    public function inserirDuvida(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $duvida = new Duvida([
                'duvida_pergunta' => $request->message
            ]);
            $duvida->duvida_user = $request->user()->id;

            if( $duvida->save() ){
                return response()->json([
                    'success' => true,
                    'id' => str_replace(']', '', str_replace('[', '', $duvida->duvida_id) )
                ]);
            } else{
                return response()->json([
                    'success' => false
                ],401);
            }
        }
    }

     public function getDuvidasDoUser(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $duvidas = Duvida::where('duvida_user',$request->user()->id)->orderBy('created_at','desc')->get();

            return $duvidas;
        }
    }

    public function getDuvidasParaTodos(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $duvidas = Duvida::where('duvida_paraTodos',1)->orderBy('created_at','desc')->get();
            return $duvidas;
        }
    }

}
