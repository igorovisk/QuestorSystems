<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CreateServicoCobrancaDTO extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string $nome_servico,
        #[Required, Numeric]
        public float $valor_total,
        #[Required, Numeric]
        public int $quantidade_parcelas,
        #[Required, Exists('clientes', 'id')]
        public int $cliente_id,
        #[Required, Exists('bancos', 'id')]
        public int $banco_id,
    ) {}
}
