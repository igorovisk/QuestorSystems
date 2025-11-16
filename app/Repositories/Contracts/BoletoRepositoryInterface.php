<?php

namespace App\Repositories\Contracts;

use App\Models\Boleto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BoletoRepositoryInterface
{
    public function all(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection;

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?Boleto;

    public function findOrFail(int $id): Boleto;

    public function create(array $data): Boleto;

    public function update(Boleto $boleto, array $data): bool;

    public function delete(Boleto $boleto): bool;
}
