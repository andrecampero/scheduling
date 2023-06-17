<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * autenticação
 */
Route::get('/login', 'Admin\Auth\AuthController@index')->name('login');
Route::post('/login', 'Admin\Auth\AuthController@authenticate')->name('authenticate');
Route::get('logout', 'Admin\Auth\AuthController@logout')->name('logout');

Route::middleware(['auth'])->namespace('Admin')->group(function () {

    /**
     * home - dashboard
     */
    Route::get('/', 'HomeController@index')->name('home');

	/* Agendamentos */
    Route::get('/agendamentos', 'AgendamentosController@index')->name('agendamentos');
    Route::get('/get-agendamentos', 'AgendamentosController@getAgendamentos')->name('get.agendamentos');
    
    Route::get('/agendamentos/agendar', 'AgendamentosController@agendar')->name('agendamentos.agendar');
    Route::post('/agendamentos/ins', 'AgendamentosController@AgendamentoIns')->name('agendamento.ins');

    Route::get('/agendamentos/alterar/{id}', 'AgendamentosController@alterar')->name('agendamentos.alterar');
    Route::post('/agendamentos/upd', 'AgendamentosController@AgendamentoUpd')->name('agendamento.upd');  

    /* Gerenciamento */
    Route::get('/gerenciamento/desempenho', 'GerenciamentoController@index')->name('gerenciamento.desempenho');
    Route::get('/get-gerenciamento', 'GerenciamentoController@getAgendamentos')->name('get.gerenciamento');
});
