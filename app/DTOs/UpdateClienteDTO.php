<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UpdateClienteDTO extends Data
{
    public function __construct(
        #[StringType, Max(255)]
        public ?string $nome = null,
        #[Email, Max(255)]
        public ?string $email = null,
    ) {}
}
