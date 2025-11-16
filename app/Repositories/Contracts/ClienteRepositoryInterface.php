<?php

namespace App\Repositories\Contracts;

use App\Models\Cliente;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClienteRepositoryInterface
{
    public function all(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection;

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?Cliente;

    public function findOrFail(int $id): Cliente;

    public function create(array $data): Cliente;

    public function update(Cliente $cliente, array $data): bool;

    public function delete(Cliente $cliente): bool;
}
