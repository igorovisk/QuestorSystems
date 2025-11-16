<?php

namespace App\Repositories;

use App\Models\Banco;
use App\Repositories\Contracts\BancoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BancoRepository implements BancoRepositoryInterface
{
    public function all(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection
    {
        $query = Banco::with('boletos');

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortOrder);

        return $query->get();
    }

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator
    {
        $query = Banco::with('boletos');

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortOrder);

        $perPage = min(max($perPage, 1), 100);

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Banco
    {
        return Banco::with('boletos')->find($id);
    }

    public function findOrFail(int $id): Banco
    {
        return Banco::with('boletos')->findOrFail($id);
    }

    public function create(array $data): Banco
    {
        return Banco::create($data);
    }

    public function update(Banco $banco, array $data): bool
    {
        return $banco->update($data);
    }

    public function delete(Banco $banco): bool
    {
        // Apesar de ser um delete, o correto é usar o método update para desativar o registro
        // e não deletar o registro permanentemente, porém não temos a coluna ativo na tabela bancos que foi especificada no teste técnico, por isso optei por deixar o delete mesmo
        // return $banco->update(['ativo' => false]);
        return $banco->delete();
    }

    protected function applyFilters($query, array $filters): void
    {
        if (isset($filters['nome_banco'])) {
            $query->where('nome_banco', 'like', '%' . $filters['nome_banco'] . '%');
        }

        if (isset($filters['codigo_banco'])) {
            $query->where('codigo_banco', 'like', '%' . $filters['codigo_banco'] . '%');
        }

        if (isset($filters['percentual_juros_min'])) {
            $query->where('percentual_juros', '>=', $filters['percentual_juros_min']);
        }

        if (isset($filters['percentual_juros_max'])) {
            $query->where('percentual_juros', '<=', $filters['percentual_juros_max']);
        }
    }

    protected function applySorting($query, string $sortBy, string $sortOrder): void
    {
        $allowedSortColumns = ['id', 'nome_banco', 'codigo_banco', 'percentual_juros', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('id', 'asc');
        }
    }
}
