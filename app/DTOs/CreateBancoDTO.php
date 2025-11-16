<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CreateBancoDTO extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string $nome_banco,
        #[Required, StringType, Max(255)]
        public string $codigo_banco,
        #[Required, Numeric]
        public float $percentual_juros,
    ) {}
}
