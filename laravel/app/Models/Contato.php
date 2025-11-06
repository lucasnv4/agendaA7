<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
//Modelo da tabela de contatos
{
    use HasFactory;

    protected $table = 'contatos'; 

    protected $fillable = [
        'Nome',
        'Email',
        'Endereco',
        'Telefone',
    ];
}