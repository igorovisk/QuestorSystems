<?php

namespace Tests\Unit;

use App\DTOs\CreateBoletoDTO;
use App\DTOs\UpdateBoletoDTO;
use App\Models\Banco;
use App\Models\Boleto;
use App\Models\Cliente;
use App\Repositories\BoletoRepository;
use App\Services\BoletoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoletoServiceTest extends TestCase
{
    use RefreshDatabase;

    private BoletoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BoletoService(new BoletoRepository);
    }

    public function test_can_create_boleto(): void
    {
        $banco = Banco::factory()->create();
        $cliente = Cliente::factory()->create();

        $dto = CreateBoletoDTO::from([
            'nome_pagador' => 'João Silva',
            'cpf_cnpj_pagador' => '12345678901',
            'nome_beneficiario' => 'Empresa XYZ',
            'cpf_cnpj_beneficiario' => '98765432000100',
            'valor' => 1000.50,
            'data_vencimento' => '2024-12-31',
            'observacao' => 'Boleto de teste',
            'banco_id' => $banco->id,
            'cliente_id' => $cliente->id,
        ]);

        $boleto = $this->service->create($dto);

        $this->assertInstanceOf(\App\DTOs\BoletoDTO::class, $boleto);
        $this->assertEquals('João Silva', $boleto->nome_pagador);
        $this->assertEquals(1000.50, $boleto->valor);
        $this->assertDatabaseHas('boletos', [
            'nome_pagador' => 'João Silva',
            'valor' => 1000.50,
            'banco_id' => $banco->id,
            'cliente_id' => $cliente->id,
        ]);
    }

    public function test_can_find_boleto_by_id(): void
    {
        $boleto = Boleto::factory()->create([
            'nome_pagador' => 'Maria Santos',
            'valor' => 500.00,
        ]);

        $found = $this->service->find($boleto->id);

        $this->assertInstanceOf(\App\DTOs\BoletoDTO::class, $found);
        $this->assertEquals($boleto->id, $found->id);
        $this->assertEquals('Maria Santos', $found->nome_pagador);
        $this->assertEquals(500.00, $found->valor);
    }

    public function test_can_update_boleto(): void
    {
        $boleto = Boleto::factory()->create([
            'nome_pagador' => 'Pedro Costa',
            'valor' => 750.00,
        ]);

        $dto = UpdateBoletoDTO::from([
            'nome_pagador' => 'Pedro Silva Costa',
            'valor' => 850.00,
        ]);

        $updated = $this->service->update($boleto->id, $dto);

        $this->assertEquals('Pedro Silva Costa', $updated->nome_pagador);
        $this->assertEquals(850.00, $updated->valor);
        $this->assertDatabaseHas('boletos', [
            'id' => $boleto->id,
            'nome_pagador' => 'Pedro Silva Costa',
            'valor' => 850.00,
        ]);
    }

    public function test_can_delete_boleto(): void
    {
        $boleto = Boleto::factory()->create();

        $result = $this->service->delete($boleto->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('boletos', [
            'id' => $boleto->id,
        ]);
    }

    public function test_can_list_boletos(): void
    {
        Boleto::factory()->count(5)->create();

        $boletos = $this->service->list();

        $this->assertCount(5, $boletos);
    }

    public function test_throws_exception_when_boleto_not_found(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->service->find(999);
    }
}
