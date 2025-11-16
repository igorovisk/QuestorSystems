<?php

namespace App\Repositories;

use App\Models\Boleto;
use App\Repositories\Contracts\BoletoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BoletoRepository implements BoletoRepositoryInterface
{
    public function all(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection
    {
        $query = Boleto::with(['cliente', 'banco']);

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortOrder);

        return $query->get();
    }

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator
    {
        $query = Boleto::with(['cliente', 'banco']);

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortOrder);

        $perPage = min(max($perPage, 1), 100);

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Boleto
    {
        return Boleto::with(['cliente', 'banco'])->find($id);
    }

    public function findOrFail(int $id): Boleto
    {
        return Boleto::with(['cliente', 'banco'])->findOrFail($id);
    }

    public function create(array $data): Boleto
    {
        return Boleto::create($data);
    }

    public function update(Boleto $boleto, array $data): bool
    {
        return $boleto->update($data);
    }

    public function delete(Boleto $boleto): bool
    {   // Apesar de ser um delete, o correto é usar o método update para desativar o registro
        // e não deletar o registro permanentemente, porém não temos a coluna ativo na tabela boletos que foi especificada no teste técnico, por isso optei por deixar o delete mesmo
        return $boleto->delete();
    }

    protected function applyFilters($query, array $filters): void
    {
        if (isset($filters['nome_pagador'])) {
            $query->where('nome_pagador', 'like', '%' . $filters['nome_pagador'] . '%');
        }

        if (isset($filters['nome_beneficiario'])) {
            $query->where('nome_beneficiario', 'like', '%' . $filters['nome_beneficiario'] . '%');
        }

        if (isset($filters['cpf_cnpj_pagador'])) {
            $query->where('cpf_cnpj_pagador', 'like', '%' . $filters['cpf_cnpj_pagador'] . '%');
        }

        if (isset($filters['valor_min'])) {
            $query->where('valor', '>=', $filters['valor_min']);
        }

        if (isset($filters['valor_max'])) {
            $query->where('valor', '<=', $filters['valor_max']);
        }

        if (isset($filters['data_vencimento_inicio'])) {
            $query->where('data_vencimento', '>=', $filters['data_vencimento_inicio']);
        }

        if (isset($filters['data_vencimento_fim'])) {
            $query->where('data_vencimento', '<=', $filters['data_vencimento_fim']);
        }

        if (isset($filters['banco_id'])) {
            $query->where('banco_id', $filters['banco_id']);
        }

        if (isset($filters['cliente_id'])) {
            $query->where('cliente_id', $filters['cliente_id']);
        }
    }

    protected function applySorting($query, string $sortBy, string $sortOrder): void
    {
        $allowedSortColumns = ['id', 'nome_pagador', 'nome_beneficiario', 'valor', 'data_vencimento', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('id', 'asc');
        }
    }
}
