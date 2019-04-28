<?php

# RECUPERAR SENHA #
Route::middleware('auth:api')->post('/recuperar-senha','ApiController@esqueciasenha');

# BAIRROS SYNC #
Route::middleware('auth:api')->get('/bairrosync','ApiController@bairrosync');

# LOGIN #
Route::middleware('auth:api')->post('/login', 'ApiController@login');

# USUARIO CRUD #
Route::middleware('auth:api')->post('/user','ApiController@cadastrarUser');
Route::middleware('auth:api')->get('/user/{userID}', 'ApiController@getUserById');
Route::middleware('auth:api')->post('/user/{userID}/editar', 'ApiController@editarUser');
Route::middleware('auth:api')->get('/user/{userID}/remover', 'ApiController@removerUser');

Route::middleware('auth:api')->post('/upload-foto-user','ApiController@uploadUserFoto');
Route::middleware('auth:api')->get('/read-foto-user', 'FileController@getUserFile');

// Route::middleware('auth:api')->put('/user/{userID}/editar', 'ApiController@editarUser');
// Route::middleware('auth:api')->delete('/user/{userID}/remover', 'ApiController@removerUser');

# CRIANCAS CRUD #
Route::middleware('auth:api')->post('/criancas', 'ApiController@cadastrarCrianca');
Route::middleware('auth:api')->get('/criancas/{criancaID}', 'ApiController@getCrianca');
Route::middleware('auth:api')->post('/criancas/{criancaID}/editar', 'ApiController@editarCrianca');
Route::middleware('auth:api')->delete('/criancas/{criancaID}/remover', 'ApiController@removerCrianca');

Route::middleware('auth:api')->get('/criancas-user', 'ApiController@getCriancasDoUser');

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
Route::middleware('auth:api')->post('/marcos','ApiController@inserirMarco');
Route::middleware('auth:api')->get('/marcos/{crianca}','ApiController@getMarcosByCrianca');
// rota abaixo feita em 03 07 2018
Route::middleware('auth:api')->get('/marcos','ApiController@getMarcosByUserId');

# ACOMPANHAMENTO #
Route::middleware('auth:api')->post('/acompanhamentos','ApiController@cadastrarAcompanhamento');
Route::middleware('auth:api')->get('/acompanhamentos','ApiController@getAcompanhamentosByUserId');

# foto #
Route::middleware('auth:api')->get('/read-foto-crianca/{filename}', 'FileController@getFile');
Route::middleware('auth:api')->post('/upload-foto-crianca', 'ApiController@uploadFoto');
Route::middleware('auth:api')->get('/fotos','ApiController@getFotosDaCriancaByUserId');
Route::middleware('auth:api')->post('/fotos','ApiController@inserirFoto');
Route::middleware('auth:api')->delete('/fotos/{fotoID}/remover','ApiController@apagarFoto');//nao vai usar

# duvidas #
Route::middleware('auth:api')->post('/conversa', 'ApiController@inserirDuvida');
Route::middleware('auth:api')->get('/conversa-user', 'ApiController@getDuvidasDoUser');
Route::middleware('auth:api')->get('/conversa-todos', 'ApiController@getDuvidasParaTodos');

Route::middleware('auth:api')->get('/conversa-user-todos', 'ApiController@getDuvidasDoUserEParaTodos');

# duvidas frequentes #
Route::middleware('auth:api')->get('/duvidas-frequentes', 'ApiController@getDuvidasFrequentes');