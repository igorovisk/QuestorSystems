<?php

namespace App\DTOs;

use Spatie\LaravelData\Data;

class ClienteDTO extends Data
{
    public function __construct(
        public ?int $id,
        public string $nome,
        public string $email,
    ) {}
}
