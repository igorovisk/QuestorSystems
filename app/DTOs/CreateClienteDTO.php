<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class CreateClienteDTO extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string $nome,
        #[Required, Email, Max(255)]
        public string $email,
    ) {}
}
