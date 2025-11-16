<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class BoletoDTO extends Data
{
    public function __construct(
        public ?int $id,
        public string $nome_pagador,
        public string $cpf_cnpj_pagador,
        public string $nome_beneficiario,
        public string $cpf_cnpj_beneficiario,
        public float $valor,
        public string $data_vencimento,
        public ?string $observacao,
        public int $banco_id,
        public int $cliente_id,
    ) {}
}
