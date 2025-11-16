<?php

namespace App\Services;

use App\DTOs\ClienteDTO;
use App\DTOs\CreateClienteDTO;
use App\DTOs\UpdateClienteDTO;
use App\Repositories\Contracts\ClienteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClienteService
{
    public function __construct(
        private readonly ClienteRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection
    {
        return $this->repository->all($filters, $sortBy, $sortOrder);
    }

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $sortBy, $sortOrder, $perPage);
    }

    public function find(int $id): ClienteDTO
    {
        $cliente = $this->repository->findOrFail($id);

        return ClienteDTO::from($cliente);
    }

    public function create(CreateClienteDTO $dto): ClienteDTO
    {
        $cliente = $this->repository->create($dto->toArray());

        return ClienteDTO::from($cliente);
    }

    public function update(int $id, UpdateClienteDTO $dto): ClienteDTO
    {
        $cliente = $this->repository->findOrFail($id);

        // Remove valores null do array
        $data = array_filter($dto->toArray(), fn($value) => $value !== null);

        $this->repository->update($cliente, $data);

        $cliente->refresh();

        return ClienteDTO::from($cliente);
    }

    public function delete(int $id): bool
    {
        $cliente = $this->repository->findOrFail($id);

        return $this->repository->delete($cliente);
    }
}
