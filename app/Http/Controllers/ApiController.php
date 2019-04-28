<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\EsqueciASenha;
use App\Mail\ChegouDuvida;
use ImageOptimizer;

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
use App\DuvidaFrequente;
use Auth;
use Validator;

class ApiController extends Controller
{
    private $default_token;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->default_token = env('API_SECRET');
    }


    /* METODOS QUE NAO PRECISAM DO API_TOKEN DO USUARIO */

    public function esqueciasenha(Request $request)
    {
        $validator = Validator::make($request->only('message'), [
            'message' => 'email',
        ]);

        if (! $validator->fails()) {

            $usuarioSolicitante = User::where('email', $request->message)->first();

            if ($usuarioSolicitante != null) {

                $senha_reserva = str_random(6);
                
                $usuarioSolicitante->senha_reserva = $senha_reserva;

                $usuarioSolicitante->update();

                Mail::to($request->message)->send(new EsqueciASenha($senha_reserva));

                return response()->json([
                    'success' => true,
                    'message' => "Senha temporária enviada com sucesso para {$request->message}. Em caso de demora verifique sua caixa de spam."
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Este e-mail não consta no nosso sistema.',
                ], 401);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'O e-mail é inválido.',
            ], 401);
        }

    }


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

        	$usuario = new User($request->except('posto_saude'));
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

    public function login(Request $request)
    {
       // $login = User::where('email',$request->email)
       //               ->where('password',$request->password)
       //               ->pluck('id')
       //               ->first();

        $login = User::where('email',$request->email)
                     ->pluck('id')
                     ->first();


       if ( $login ) {

            $senha_reserva = User::where('email',$request->email)->pluck('senha_reserva')->first();
            $api_token = User::where('email',$request->email)->pluck('api_token')->first();
            $password = User::where('email',$request->email)->pluck('password')->first();

            return response()->json([
                'success' => true,
                'message' => $api_token,
                'password' => $password,
                'senha_reserva' => $senha_reserva,
                'id' => $login
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha incorretos.',
            ], 401);
        }
        
    }

    /* FIM DOS METODOS QUE NAO PRECISAM DO API_TOKEN DO USUARIO */








    /* ########################################### METODOS DE USER ########################################### */

    public function editarUser($userID, Request $request)
    {
    	if ( $request->api_token !== $this->default_token ) {

    		$usuario = User::findOrFail($userID);

    		if($request->has('data_nascimento'))
                $request->merge(['data_nascimento' => substr($request->data_nascimento, 0,10)]);

            if ($request->has('foto_url')) {
                if ($request->foto_url == "") {
                    if ($usuario->foto_url != "" || $usuario->foto_url == null) {
                        Storage::disk('local')->delete($usuario->foto_url);
                        $usuario->foto_url = null;
                    }
                }
            }

            if(!($request->has('posto_saude'))){

                    if( $usuario->update( $request->all() ) ) {
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
            } else {

                if ( $request->posto_saude != 0) {
                    if( $usuario->update( $request->all() ) ) {
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
                } else {
                    if( $usuario->update( $request->except('posto_saude') ) ) {
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
	        
    	}
    }

    public function removerUser(Request $request, $userID)
    {
        if ( $request->api_token !== $this->default_token ) {
            
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
    }

    public function uploadUserFoto(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            if($request->hasFile('foto')) {

                $user = $request->user();

                if( $user->foto_url != null ) {
                    // apagar foto antiga            
                    Storage::disk('local')->delete($user->foto_url);
                }

                $path = $request->file('foto')->store('fotos_user');

                ImageOptimizer::optimize(storage_path('app/' . $path ));

                $user->foto_url = $path;

                if ( $user->update() ) {
                    return response()->json([
                        'success' => true
                    ]);
                } else {
                    return response()->json([
                        'success' => false
                    ], 401);
                }

            } else {
                return response()->json([
                        'success' => false
                    ], 401);
            }
        }

    }

    public function getUserById(Request $request,$userID)
    {
        // return User::with('criancas')->where('id',$userID)->get()->first();

        if ( $request->api_token !== $this->default_token ) {

            $user = User::where('id',$userID)->get()->first();

            $criancasDoUser = Crianca::where('user_id', $userID)->get();

            $criancasId = array();

            foreach ($criancasDoUser as $crianca) {
                array_push($criancasId, $crianca->crianca_id);
            }

            $user["criancas"] = $criancasId;

            return $user;
        }

    }

    /* ########################################################################################################### */











    /* ########################################### METODOS DE FOTO ########################################### */
    

    public function uploadFoto(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

        	if ( $request->has('foto') && $request->has('crianca') && $request->has('mes') ) {
				
				if($request->hasFile('foto')){

                    // verificar se ja existe foto pra aquela crianca naquele mes

                    $oldfoto = Foto::where('crianca',$request->crianca)->where('mes',$request->mes)->first();

                    if( $oldfoto != null ) {
                        Storage::disk('local')->delete( 'fotos_criancas/' . $oldfoto->url );
                        $oldfoto->delete();
                    }

	                $path = $request->file('foto')->store('fotos_criancas');

                    ImageOptimizer::optimize(storage_path('app/' . $path ));

	                $urlPath = substr($path, strpos($path, '/') + 1);

	                $foto = new Foto([
	                    'crianca' => $request->crianca,
	                    'mes' => $request->mes,
	                    'url' => $urlPath
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
	                        'success' => false,
	                        'message' => 'envie uma foto.'
	                    ], 401);
             	}
        	} else {
        		return response()->json([
	                        'success' => false,
	                        'message' => 'Envie todos os campos.'
	                    ], 401);
        	}
        }

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

    //maybe not used
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
                foreach ($crianca->fotos as $foto) {
                    array_push($fotosDaCrianca, $foto);
                }
            }

            return $fotosDaCrianca;
        }

    }

    public function apagarFoto(Request $request, $fotoID)
    {
        if ( $request->api_token !== $this->default_token ) {

            $foto = Foto::findOrFail($fotoID);

            if ( $foto->delete() ) {
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
    }

    /* ########################################################################################################### */









    /* ########################################### METODOS DE CRIANÇAS ########################################### */

        public function cadastrarCrianca(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {
            
            $crianca = new Crianca($request->except(['crianca_tipo_parto','crianca_idade_gestacional']));
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

    public function removerCrianca(Request $request, $criancaID)
    {
        if ( $request->api_token !== $this->default_token ) {

            $crianca = Crianca::with('fotos')->findOrFail($criancaID);

            $apagarFotos = false;
            $fotos = null;

            if ($crianca->fotos != "[]") {
                $apagarFotos = true;
                $fotos = $crianca->fotos; 
            }

            if ( $crianca->delete() ) {

                if ($apagarFotos) {

                    foreach ($fotos as $foto) {
                        Storage::disk('local')->delete('fotos_criancas/'. $foto->url);
                    }

                }

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
    }

    public function getCrianca(Request $request, $criancaID)
    {
        if ( $request->api_token !== $this->default_token )
            return Crianca::findOrFail($criancaID);
    }

    public function getCriancasByUserId(Request $request, $userID)
    {
        if ( $request->api_token !== $this->default_token )
            return Crianca::where('user_id',$userID)->get();
    }

    public function getCriancasDoUser(Request $request)
    {
        if ( $request->api_token !== $this->default_token )
            return Crianca::where('user_id',$request->user()->id)->get();
    }


    /* ########################################################################################################### */












    /* ########################################### METODOS DE DUVIDAS ########################################### */

    public function getDuvidasFrequentes(Request $request)
    {
        if ( $request->api_token !== $this->default_token )
            return DuvidaFrequente::with('links')->orderBy('titulo')->get();
    }


    public function inserirDuvida(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $duvida = new Duvida([
                'pergunta' => $request->message
            ]);
            $duvida->user = $request->user()->id;

            if( $duvida->save() ){
                // Mail::to(env('MAIL_USERNAME'))->send(new ChegouDuvida($request->user()->email, $request->message, $duvida->id));
                return response()->json([
                    'success' => true,
                    'id' => str_replace(']', '', str_replace('[', '', $duvida->id) )
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

            $duvidas = Duvida::where('user',$request->user()->id)->orderBy('created_at','desc')->get();

            return $duvidas;
        }
    }

    public function getDuvidasParaTodos(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $duvidas = Duvida::where('paraTodos',1)->orderBy('created_at','desc')->get();
            return $duvidas;
        }
    }

    public function getDuvidasDoUserEParaTodos(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $duvidas = Duvida::where('user',$request->user()->id)->orWhere('paraTodos',1)->orderBy('created_at','desc')->get();

            return $duvidas;
        }
    }

    /* ########################################################################################################### */









    /* ########################################### METODOS DE MARCOS ########################################### */

    public function inserirMarco(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {

            $marco = new Marco($request->all());
            $marco->data = substr($marco->data, 0,10);

            if( $marco->save() ){

                return response()->json([
                        'success' => true,
                        'id' => intval($marco->id)
                    ]);

            } else {
                return response()->json([
                        'success' => false,
                        'message' => 'could not save',
                    ], 401);
            }

        }
    }


    public function getMarcosByUserId(Request $request)
    {
        if ( $request->api_token !== $this->default_token ) {
            $criancasByUserId = Crianca::with('marcos')->where('user_id',$request->user()->id)->get();

            $marcos = array();
            foreach ($criancasByUserId as $crianca) {
                foreach ($crianca->marcos as $marco) {
                    array_push($marcos, $marco);
                }
            }

            return $marcos;
        }
    }

    /* ########################################################################################################### */









    /* ########################################### METODOS DE ACOMPANHAMENTO ########################################### */

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
                foreach ($crianca->acompanhamentos as $acompanhamento) {
                    array_push($acompanhamentos, $acompanhamento);
                }
            }

            return $acompanhamentos;
        }

    }


    /* ########################################################################################################### */












    /* ########################################### METODOS DE BAIRRO ########################################### */

    public function bairrosync()
    {
        $id = Sincronizacao::pluck('bairro')->first();

        return response()->json([
                    'success' => true,
                    'id' => intval($id)
                ]);
    }

    /* ########################################################################################################### */









    




    /* ########################################### METODOS GET ########################################### */

    public function getBairros()
    {
        return Bairro::get();
    }

    public function getNotificacoes(Request $request)
    {
        if ( $request->api_token !== $this->default_token )
            return Notificacao::get();
    }

    public function getSincronizacaoTable(Request $request)
    {
        if ( $request->api_token !== $this->default_token )
    	   return Sincronizacao::first();
    }

    public function getInformacoes(Request $request)
    {
        if ( $request->api_token !== $this->default_token )
            return Informacao::with('links')->get();
    }

    public function getPostos(Request $request)
    {
        if ( $request->api_token !== $this->default_token )
    	   return Posto::get();
    }

    /* ########################################################################################################### */

}
