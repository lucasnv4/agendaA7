<?php

use Illuminate\Support\Facades\Route;
use App\Models\Contatos;

Route::get('/', function () {
    return view('welcome');
});


//Criação de novo contato
Route::post('/criarContato', function () {
    return Contato::create(request()->all());
});
