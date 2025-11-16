<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UpdateBoletoDTO extends Data
{
    public function __construct(
        #[StringType, Max(255)]
        public ?string $nome_pagador = null,
        #[StringType, Max(18)]
        public ?string $cpf_cnpj_pagador = null,
        #[StringType, Max(255)]
        public ?string $nome_beneficiario = null,
        #[StringType, Max(18)]
        public ?string $cpf_cnpj_beneficiario = null,
        #[Numeric]
        public ?float $valor = null,
        #[Date]
        public ?string $data_vencimento = null,
        #[StringType]
        public ?string $observacao = null,
        #[Exists('bancos', 'id')]
        public ?int $banco_id = null,
        #[Exists('clientes', 'id')]
        public ?int $cliente_id = null,
    ) {}
}
