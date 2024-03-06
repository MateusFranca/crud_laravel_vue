<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'telefone', 'sexo', 'foto'];

    public function getUrlImagemAttribute()
    {
        return asset("storage/{$this->foto}");
    }

    public static $rules = [
        'nome' => 'required|string|max:255',
        'email' => 'required|email|unique:clientes,email',
        'telefone' => 'required|regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/',
        'sexo' => 'required|in:masculino,feminino',
        'foto' => 'required|file|mimes:png,jpeg,jpg',
    ];

    public static $messages = [
        'nome.required' => 'O campo nome é obrigatório.',
        'nome.min' => 'O nome deve ter pelo menos :min caracteres.',
        'nome.max' => 'O nome não pode ter mais de :max caracteres.',
        'email.required' => 'O campo email é obrigatório.',
        'email.email' => 'Informe um endereço de email válido.',
        'telefone.required' => 'O campo telefone é obrigatório.',
        'telefone.regex' => 'O telefone deve estar no formato (99)99999-9999.',
        'sexo.required' => 'O campo sexo é obrigatório.',
        'sexo.in' => 'Selecione uma opção válida para o campo sexo.',
        'unique' => 'Este :attribute já está sendo usado.',
        'foto.required' => 'O campo foto é obrigatório.',
        'foto.file' => 'O arquivo enviado não é válido.',
        'foto.mimes' => 'A foto deve estar no formato PNG, JPEG ou JPG.',
    ];
}
