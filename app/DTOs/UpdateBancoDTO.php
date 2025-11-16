<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UpdateBancoDTO extends Data
{
    public function __construct(
        #[StringType, Max(255)]
        public ?string $nome_banco = null,
        #[StringType, Max(255)]
        public ?string $codigo_banco = null,
        #[Numeric]
        public ?float $percentual_juros = null,
    ) {}
}
