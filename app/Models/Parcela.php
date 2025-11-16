<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parcela extends Model
{
    use HasFactory;

    protected $fillable = [
        'servico_cobranca_id',
        'numero_parcela',
        'valor',
        'data_vencimento',
        'enviado_email',
        'enviado_em',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'numero_parcela' => 'integer',
        'data_vencimento' => 'date',
        'enviado_email' => 'boolean',
        'enviado_em' => 'datetime',
    ];

    public function servicoCobranca(): BelongsTo
    {
        return $this->belongsTo(ServicoCobranca::class);
    }
}
