<?php

namespace App\Services;

use App\DTOs\BoletoDTO;
use App\DTOs\CreateBoletoDTO;
use App\DTOs\UpdateBoletoDTO;
use App\Repositories\Contracts\BoletoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BoletoService
{
    public function __construct(
        private readonly BoletoRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection
    {
        return $this->repository->all($filters, $sortBy, $sortOrder);
    }

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $sortBy, $sortOrder, $perPage);
    }

    public function find(int $id): BoletoDTO
    {
        $boleto = $this->repository->findOrFail($id);

        return BoletoDTO::from($boleto);
    }

    public function create(CreateBoletoDTO $dto): BoletoDTO
    {
        $boleto = $this->repository->create($dto->toArray());

        return BoletoDTO::from($boleto);
    }

    public function update(int $id, UpdateBoletoDTO $dto): BoletoDTO
    {
        $boleto = $this->repository->findOrFail($id);

        // Remove valores null do array
        $data = array_filter($dto->toArray(), fn($value) => $value !== null);

        $this->repository->update($boleto, $data);

        $boleto->refresh();

        return BoletoDTO::from($boleto);
    }

    public function delete(int $id): bool
    {
        $boleto = $this->repository->findOrFail($id);

        return $this->repository->delete($boleto);
    }
}
