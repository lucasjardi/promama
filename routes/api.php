<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


# LOGIN #
Route::middleware('auth:api')->post('/login', 'ApiController@login');

# USUARIO CRUD #
Route::middleware('auth:api')->post('/user','ApiController@cadastrarUser');
Route::middleware('auth:api')->get('/user/{userID}', 'ApiController@getUserById');
Route::middleware('auth:api')->post('/user/{userID}/editar', 'ApiController@editarUser');
Route::middleware('auth:api')->get('/user/{userID}/remover', 'ApiController@removerUser');
// Route::middleware('auth:api')->put('/user/{userID}/editar', 'ApiController@editarUser');
// Route::middleware('auth:api')->delete('/user/{userID}/remover', 'ApiController@removerUser');

# CRIANCAS CRUD #
Route::middleware('auth:api')->post('/criancas', 'ApiController@cadastrarCrianca');
Route::middleware('auth:api')->get('/criancas/{criancaID}', 'ApiController@getCrianca');
Route::middleware('auth:api')->post('/criancas/{criancaID}/editar', 'ApiController@editarCrianca');
Route::middleware('auth:api')->get('/criancas/{criancaID}/remover', 'ApiController@removerCrianca');
// Route::middleware('auth:api')->put('/criancas/{criancaID}/editar', 'ApiController@editarCrianca');
// Route::middleware('auth:api')->delete('/criancas/{criancaID}/remover', 'ApiController@removerCrianca');

# RESGATAR ARRAY DE CRIANCAS DE UM USUARIO #
Route::middleware('auth:api')->get('/criancas/{userID}/user', 'ApiController@getCriancasByUserId');


# TODAS INFORMACOES #
Route::middleware('auth:api')->get('/informacoes', 'ApiController@getInformacoes');

# TODOS BAIRROS #
Route::middleware('auth:api')->get('/bairros', 'ApiController@getBairros');

# TODOS OS POSTO #
Route::middleware('auth:api')->get('/postos','ApiController@getPostos');

# GET SINCRONIZACAO #
Route::middleware('auth:api')->get('/sync','ApiController@getSincronizacaoTable');

# GET NOTIFICACOES #
Route::middleware('auth:api')->get('/notificacoes','ApiController@getNotificacoes');

# MARCO #
Route::middleware('auth:api')->get('/marcos','ApiController@getMarcosByUserId');
Route::middleware('auth:api')->post('/marcos/{marcoID}/editar','ApiController@editarMarco');

# ACOMPANHAMENTO #
Route::middleware('auth:api')->post('/acompanhamentos','ApiController@cadastrarAcompanhamento');
Route::middleware('auth:api')->get('/acompanhamentos','ApiController@getAcompanhamentosByUserId');

# foto #
Route::middleware('auth:api')->get('file/{filename}', 'FileController@getFile')->where('filename', '^[^/]+$');
Route::middleware('auth:api')->post('uploadfoto', 'ApiController@uploadFoto');
Route::middleware('auth:api')->get('/fotos','ApiController@getFotosDaCriancaByUserId');
Route::middleware('auth:api')->post('/fotos','ApiController@inserirFoto');
Route::middleware('auth:api')->post('/fotos/{fotoID}/editar','ApiController@updateFoto');

# inserir duvidas #
Route::middleware('auth:api')->post('/duvidas', 'ApiController@inserirDuvida');
Route::middleware('auth:api')->get('/duvidas-do-user', 'ApiController@getDuvidasDoUser');
Route::middleware('auth:api')->get('/duvidas-todos', 'ApiController@getDuvidasParaTodos');