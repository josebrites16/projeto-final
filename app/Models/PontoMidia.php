<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoMidia extends Model
{
    protected $fillable = ['ponto_id', 'tipo', 'caminho'];

    public function ponto()
    {
        return $this->belongsTo(Ponto::class);
    }
}
