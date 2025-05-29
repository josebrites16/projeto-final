<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'distancia',
        'zona',
        'coordenadas',
        'imagem',
    ];

    protected $casts = [
        'coordenadas' => 'array',
    ];

    public function pontos()
    {
        return $this->hasMany(Ponto::class);
    }
}
