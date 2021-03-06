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

Route::get('/termo-de-compromisso','TermosController@get');


Route::get('/','HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

Route::get('/renderizar/{infoId}', 'InformacoesController@renderizarInformacaoSmartphone');

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

// fale conosco

Route::prefix('duvidas')->group(function (){
    Route::get('', 'DuvidasController@index')->name('duvidas');
    Route::get('/respondidas', 'DuvidasController@renderizaRespondidas');
    Route::get('/{duvida}','DuvidasController@read');
    Route::get('/{duvida}/editar','DuvidasController@read');
    Route::patch('/{duvida}','DuvidasController@atualizar');
    Route::post('/responderDuvida', 'DuvidasController@responderDuvida');
    Route::delete('/{duvida}','DuvidasController@deletar');
});

// duvidas frequentes

Route::prefix('duvidas-frequentes')->group(function (){
    Route::get('', 'DuvidaFrequenteController@index');
    Route::get('/novo', 'DuvidaFrequenteController@novo');
    Route::post('/salvar', 'DuvidaFrequenteController@salvar');
    Route::get('/{duvidafrequente}/editar','DuvidaFrequenteController@editar');
    Route::patch('/{duvidafrequente}','DuvidaFrequenteController@atualizar');
    Route::delete('/{duvidafrequente}','DuvidaFrequenteController@deletar');
});

// notificacoes

Route::prefix('notificacoes')->group(function (){
    Route::get('', 'NotificacoesController@index');
    Route::get('/novo', 'NotificacoesController@novo');
    Route::post('/salvar', 'NotificacoesController@store');
    Route::get('/{notificacao}/editar','NotificacoesController@editar');
    Route::patch('/{notificacao}','NotificacoesController@atualizar');
    Route::delete('/{notificacao}','NotificacoesController@deletar');
});

Route::prefix('usuarios')->group(function()
{
    Route::get('', 'UsuariosController@index');
});

Route::prefix('config')->group(function()
{
    Route::get('','ConfigController@showChangePasswordForm')->name('config');
    Route::post('/changePassword','ConfigController@changePassword')->name('changePassword');
    // Route::patch('/{id}','ConfigController@update');
});

Route::prefix('termos')->group(function (){
    Route::get('', 'TermosController@index');
    Route::patch('/atualizar','TermosController@atualizar');
});