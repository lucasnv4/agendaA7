<?php
use Illuminate\Support\Facades\Route;
use App\Models\Contato;

//Listagem de contatos cadastrados
Route::get('/contatos', function () {
    return Contato::all();
});

//Criação de novo contato
Route::post('/criarContato', function () {
    return Contato::create(request()->all());
});

//Atualização de contato existente, fornecendo id numérico
Route::put('/atualizarContato/{id}', function ($id) {
    $contato = Contato::findOrFail($id);
    $contato->update(request()->all());
    return $contato;
});

//Exclusão de contato existente, fornecendo id numérico
Route::delete('/excluirContato/{id}', function ($id) {
    Contato::findOrFail($id)->delete();
    return response()->noContent();
});
