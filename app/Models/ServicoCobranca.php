<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicoCobranca extends Model
{
    use HasFactory;

    protected $table = 'servicos_cobranca';

    protected $fillable = [
        'nome_servico',
        'valor_total',
        'quantidade_parcelas',
        'cliente_id',
        'banco_id',
        'parcelas_geradas',
    ];

    protected $casts = [
        'valor_total' => 'decimal:2',
        'quantidade_parcelas' => 'integer',
        'parcelas_geradas' => 'boolean',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function banco(): BelongsTo
    {
        return $this->belongsTo(Banco::class);
    }

    public function parcelas(): HasMany
    {
        return $this->hasMany(Parcela::class);
    }
}
