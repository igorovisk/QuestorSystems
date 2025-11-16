<?php

namespace App\Repositories\Contracts;

use App\Models\Banco;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BancoRepositoryInterface
{
    public function all(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection;

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator;

    public function find(int $id): ?Banco;

    public function findOrFail(int $id): Banco;

    public function create(array $data): Banco;

    public function update(Banco $banco, array $data): bool;

    public function delete(Banco $banco): bool;
}
