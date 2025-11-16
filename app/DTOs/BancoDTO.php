<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class BancoDTO extends Data
{
    public function __construct(
        public ?int $id,
        public string $nome_banco,
        public string $codigo_banco,
        public float $percentual_juros,
    ) {}
}
