<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banco extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_banco',
        'codigo_banco',
        'percentual_juros',
    ];

    public function boletos(): HasMany
    {
        return $this->hasMany(Boleto::class);
    }
}
