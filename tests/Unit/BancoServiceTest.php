<?php

namespace Tests\Unit;

use App\DTOs\CreateBancoDTO;
use App\DTOs\UpdateBancoDTO;
use App\Models\Banco;
use App\Repositories\BancoRepository;
use App\Services\BancoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BancoServiceTest extends TestCase
{
    use RefreshDatabase;

    private BancoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BancoService(new BancoRepository);
    }

    public function test_can_create_banco(): void
    {
        $dto = CreateBancoDTO::from([
            'nome_banco' => 'Banco do Brasil',
            'codigo_banco' => '001',
            'percentual_juros' => 2.5,
        ]);

        $banco = $this->service->create($dto);

        $this->assertInstanceOf(\App\DTOs\BancoDTO::class, $banco);
        $this->assertEquals('Banco do Brasil', $banco->nome_banco);
        $this->assertEquals('001', $banco->codigo_banco);
        $this->assertEquals(2.5, $banco->percentual_juros);
        $this->assertDatabaseHas('bancos', [
            'nome_banco' => 'Banco do Brasil',
            'codigo_banco' => '001',
            'percentual_juros' => 2.5,
        ]);
    }

    public function test_can_find_banco_by_id(): void
    {
        $banco = Banco::factory()->create([
            'nome_banco' => 'Itaú',
            'codigo_banco' => '341',
            'percentual_juros' => 3.0,
        ]);

        $found = $this->service->find($banco->id);

        $this->assertInstanceOf(\App\DTOs\BancoDTO::class, $found);
        $this->assertEquals($banco->id, $found->id);
        $this->assertEquals('Itaú', $found->nome_banco);
        $this->assertEquals('341', $found->codigo_banco);
    }

    public function test_can_update_banco(): void
    {
        $banco = Banco::factory()->create([
            'nome_banco' => 'Bradesco',
            'codigo_banco' => '237',
            'percentual_juros' => 2.0,
        ]);

        $dto = UpdateBancoDTO::from([
            'nome_banco' => 'Bradesco Atualizado',
            'percentual_juros' => 2.5,
        ]);

        $updated = $this->service->update($banco->id, $dto);

        $this->assertEquals('Bradesco Atualizado', $updated->nome_banco);
        $this->assertEquals(2.5, $updated->percentual_juros);
        $this->assertDatabaseHas('bancos', [
            'id' => $banco->id,
            'nome_banco' => 'Bradesco Atualizado',
            'percentual_juros' => 2.5,
        ]);
    }

    public function test_can_delete_banco(): void
    {
        $banco = Banco::factory()->create();

        $result = $this->service->delete($banco->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('bancos', [
            'id' => $banco->id,
        ]);
    }

    public function test_can_list_bancos(): void
    {
        Banco::factory()->count(5)->create();

        $bancos = $this->service->list();

        $this->assertCount(5, $bancos);
    }

    public function test_can_filter_bancos_by_nome(): void
    {
        Banco::factory()->create(['nome_banco' => 'Banco A']);
        Banco::factory()->create(['nome_banco' => 'Banco B']);
        Banco::factory()->create(['nome_banco' => 'Banco C']);

        $filtered = $this->service->paginate(['nome_banco' => 'Banco A'], 'id', 'asc', 15);

        $this->assertEquals(1, $filtered->total());
        $this->assertEquals('Banco A', $filtered->items()[0]->nome_banco);
    }

    public function test_throws_exception_when_banco_not_found(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->service->find(999);
    }
}
