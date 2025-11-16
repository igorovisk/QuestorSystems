<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CreateBoletoDTO extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string $nome_pagador,
        #[Required, StringType, Max(18)]
        public string $cpf_cnpj_pagador,
        #[Required, StringType, Max(255)]
        public string $nome_beneficiario,
        #[Required, StringType, Max(18)]
        public string $cpf_cnpj_beneficiario,
        #[Required, Numeric]
        public float $valor,
        #[Required, Date]
        public string $data_vencimento,
        #[StringType]
        public ?string $observacao,
        #[Required, Exists('bancos', 'id')]
        public int $banco_id,
        #[Required, Exists('clientes', 'id')]
        public int $cliente_id,
    ) {}
}
