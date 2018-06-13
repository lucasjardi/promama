<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/','HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

Route::get('/renderizar/{infoId}', 'InformacoesController@renderizarInformacaoSmartphone');

Route::get('/notificar', 'NotificacoesController@index');
Route::post('/notificar/salvar', 'NotificacoesController@store');

// bairros
Route::prefix('bairros')->group(function (){
    Route::get('','BairrosController@index');
    Route::get('/novo','BairrosController@novo');
    Route::get('/{bairro}/editar','BairrosController@editar');
    Route::post('/salvar','BairrosController@salvar');
    Route::patch('/{bairro}','BairrosController@atualizar');
    Route::delete('/{bairro}','BairrosController@deletar');
    Route::post('/pesquisa','BairrosController@pesquisar');
});

// informacoes

Route::prefix('informacoes')->group(function (){
    Route::get('','InformacoesController@index');
    Route::get('/novo','InformacoesController@novo');
    Route::post('/salvar','InformacoesController@salvar');
    Route::get('/{info}/editar','InformacoesController@editar');
    Route::patch('/{info}','InformacoesController@atualizar');
    Route::delete('/{info}','InformacoesController@deletar');
});

// postos

Route::prefix('postos')->group(function (){
    Route::get('', 'PostosController@index');
    Route::get('/novo', 'PostosController@novo');
    Route::post('/salvar', 'PostosController@salvar');
    Route::get('/{posto}/editar','PostosController@editar');
    Route::patch('/{posto}','PostosController@atualizar');
    Route::delete('/{posto}','PostosController@deletar');
});

Route::prefix('duvidas')->group(function (){
    Route::get('', 'DuvidasController@index');
    Route::get('/respondidas', 'DuvidasController@renderizaRespondidas');
    Route::get('/{duvida}','DuvidasController@read');
    Route::get('/{duvida}/editar','DuvidasController@read');
    Route::patch('/{duvida}','DuvidasController@atualizar');
    Route::post('/responderDuvida', 'DuvidasController@responderDuvida');
});