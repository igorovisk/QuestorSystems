<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Boleto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_pagador',
        'cpf_cnpj_pagador',
        'nome_beneficiario',
        'cpf_cnpj_beneficiario',
        'valor',
        'data_vencimento',
        'observacao',
        'banco_id',
        'cliente_id',
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'valor' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function banco(): BelongsTo
    {
        return $this->belongsTo(Banco::class);
    }
}
