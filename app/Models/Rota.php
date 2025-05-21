<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rota extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descricao', 'distancia', 'coordenadas', 'zona', 'imagem'];

    protected $casts = [
        'coordenadas' => 'array'
    ];

    public function pontos()
    {
        return $this->hasMany(Ponto::class);
    }
}
