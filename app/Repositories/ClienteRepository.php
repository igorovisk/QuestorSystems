<?php

namespace App\Repositories;

use App\Models\Cliente;
use App\Repositories\Contracts\ClienteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function all(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection
    {
        $query = Cliente::with('boletos');

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortOrder);

        return $query->get();
    }

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator
    {
        $query = Cliente::with('boletos');

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortOrder);

        $perPage = min(max($perPage, 1), 100);

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Cliente
    {
        return Cliente::with('boletos')->find($id);
    }

    public function findOrFail(int $id): Cliente
    {
        return Cliente::with('boletos')->findOrFail($id);
    }

    public function create(array $data): Cliente
    {
        return Cliente::create($data);
    }

    public function update(Cliente $cliente, array $data): bool
    {
        return $cliente->update($data);
    }

    public function delete(Cliente $cliente): bool
    {   // Apesar de ser um delete, o correto é usar o método update para desativar o registro
        // e não deletar o registro permanentemente, porém não temos a coluna ativo na tabela clientes que foi especificada no teste técnico, por isso optei por deixar o delete mesmo
        return $cliente->delete();
    }

    protected function applyFilters($query, array $filters): void
    {
        if (isset($filters['nome'])) {
            $query->where('nome', 'like', '%' . $filters['nome'] . '%');
        }

        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }
    }

    protected function applySorting($query, string $sortBy, string $sortOrder): void
    {
        $allowedSortColumns = ['id', 'nome', 'email', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('id', 'asc');
        }
    }
}
