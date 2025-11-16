<?php

namespace Tests\Unit;

use App\DTOs\CreateClienteDTO;
use App\DTOs\UpdateClienteDTO;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use App\Services\ClienteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteServiceTest extends TestCase
{
    use RefreshDatabase;

    private ClienteService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ClienteService(new ClienteRepository);
    }

    public function test_can_create_cliente(): void
    {
        $dto = CreateClienteDTO::from([
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
        ]);

        $cliente = $this->service->create($dto);

        $this->assertInstanceOf(\App\DTOs\ClienteDTO::class, $cliente);
        $this->assertEquals('João Silva', $cliente->nome);
        $this->assertEquals('joao@example.com', $cliente->email);
        $this->assertDatabaseHas('clientes', [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
        ]);
    }

    public function test_can_find_cliente_by_id(): void
    {
        $cliente = Cliente::factory()->create([
            'nome' => 'Maria Santos',
            'email' => 'maria@example.com',
        ]);

        $found = $this->service->find($cliente->id);

        $this->assertInstanceOf(\App\DTOs\ClienteDTO::class, $found);
        $this->assertEquals($cliente->id, $found->id);
        $this->assertEquals('Maria Santos', $found->nome);
        $this->assertEquals('maria@example.com', $found->email);
    }

    public function test_can_update_cliente(): void
    {
        $cliente = Cliente::factory()->create([
            'nome' => 'Pedro Costa',
            'email' => 'pedro@example.com',
        ]);

        $dto = UpdateClienteDTO::from([
            'nome' => 'Pedro Silva Costa',
            'email' => 'pedro.silva@example.com',
        ]);

        $updated = $this->service->update($cliente->id, $dto);

        $this->assertEquals('Pedro Silva Costa', $updated->nome);
        $this->assertEquals('pedro.silva@example.com', $updated->email);
        $this->assertDatabaseHas('clientes', [
            'id' => $cliente->id,
            'nome' => 'Pedro Silva Costa',
            'email' => 'pedro.silva@example.com',
        ]);
    }

    public function test_can_delete_cliente(): void
    {
        $cliente = Cliente::factory()->create();

        $result = $this->service->delete($cliente->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('clientes', [
            'id' => $cliente->id,
        ]);
    }

    public function test_can_list_clientes(): void
    {
        Cliente::factory()->count(3)->create();

        $clientes = $this->service->list();

        $this->assertCount(3, $clientes);
    }

    public function test_can_paginate_clientes(): void
    {
        Cliente::factory()->count(20)->create();

        $paginated = $this->service->paginate([], 'id', 'asc', 10);

        $this->assertEquals(20, $paginated->total());
        $this->assertEquals(10, $paginated->perPage());
        $this->assertEquals(2, $paginated->lastPage());
    }

    public function test_can_filter_clientes_by_nome(): void
    {
        Cliente::factory()->create(['nome' => 'João Silva']);
        Cliente::factory()->create(['nome' => 'Maria Santos']);
        Cliente::factory()->create(['nome' => 'Pedro Costa']);

        $filtered = $this->service->paginate(['nome' => 'João'], 'id', 'asc', 15);

        $this->assertEquals(1, $filtered->total());
        $this->assertEquals('João Silva', $filtered->items()[0]->nome);
    }

    public function test_throws_exception_when_cliente_not_found(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->service->find(999);
    }
}
