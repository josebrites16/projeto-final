<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PontoImagem extends Model
{
    protected $fillable = ['ponto_id', 'caminho'];

    public function ponto()
    {
        return $this->belongsTo(Ponto::class);
    }
}
