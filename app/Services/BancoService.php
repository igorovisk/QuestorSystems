<?php

namespace App\Services;

use App\DTOs\BancoDTO;
use App\DTOs\CreateBancoDTO;
use App\DTOs\UpdateBancoDTO;
use App\Repositories\Contracts\BancoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BancoService
{
    public function __construct(
        private readonly BancoRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc'): Collection
    {
        return $this->repository->all($filters, $sortBy, $sortOrder);
    }

    public function paginate(array $filters = [], string $sortBy = 'id', string $sortOrder = 'asc', int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $sortBy, $sortOrder, $perPage);
    }

    public function find(int $id): BancoDTO
    {
        $banco = $this->repository->findOrFail($id);

        return BancoDTO::from($banco);
    }

    public function create(CreateBancoDTO $dto): BancoDTO
    {
        $banco = $this->repository->create($dto->toArray());

        return BancoDTO::from($banco);
    }

    public function update(int $id, UpdateBancoDTO $dto): BancoDTO
    {
        $banco = $this->repository->findOrFail($id);

        // Remove valores null do array
        $data = array_filter($dto->toArray(), fn($value) => $value !== null);

        $this->repository->update($banco, $data);

        $banco->refresh();

        return BancoDTO::from($banco);
    }

    public function delete(int $id): bool
    {
        $banco = $this->repository->findOrFail($id);

        return $this->repository->delete($banco);
    }
}
