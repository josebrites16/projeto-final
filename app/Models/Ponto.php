<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ponto extends Model
{
    protected $fillable = ['titulo', 'descricao', 'coordenadas', 'rota_id'];

    protected $casts = [
        'coordenadas' => 'array',
    ];

    public function rota()
    {
        return $this->belongsTo(Rota::class);
    }

    public function midias()
    {
        return $this->hasMany(PontoMidia::class);
    }
}
