<?php

namespace Tests\Unit;

use App\Jobs\GerarParcelasEEnviarEmail;
use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Parcela;
use App\Models\ServicoCobranca;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GerarParcelasEEnviarEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_parcelas(): void
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $banco = Banco::factory()->create();

        $servico = ServicoCobranca::create([
            'nome_servico' => 'Serviço de Teste',
            'valor_total' => 1000.00,
            'quantidade_parcelas' => 5,
            'cliente_id' => $cliente->id,
            'banco_id' => $banco->id,
            'parcelas_geradas' => false,
        ]);

        $job = new GerarParcelasEEnviarEmail($servico);
        $job->handle();

        // Verifica se as parcelas foram criadas
        $parcelas = Parcela::where('servico_cobranca_id', $servico->id)->get();
        $this->assertCount(5, $parcelas);

        // Verifica valor de cada parcela (1000 / 5 = 200)
        foreach ($parcelas as $parcela) {
            $this->assertEquals(200.00, (float) $parcela->valor);
            $this->assertNotNull($parcela->data_vencimento);
            // Após enviar email, parcelas são marcadas como enviadas
            $this->assertTrue($parcela->enviado_email);
        }

        // Verifica se foi marcado como gerado
        $servico->refresh();
        $this->assertTrue($servico->parcelas_geradas);
    }

    public function test_parcelas_have_correct_sequence(): void
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $banco = Banco::factory()->create();

        $servico = ServicoCobranca::create([
            'nome_servico' => 'Serviço de Teste',
            'valor_total' => 300.00,
            'quantidade_parcelas' => 3,
            'cliente_id' => $cliente->id,
            'banco_id' => $banco->id,
            'parcelas_geradas' => false,
        ]);

        $job = new GerarParcelasEEnviarEmail($servico);
        $job->handle();

        $parcelas = Parcela::where('servico_cobranca_id', $servico->id)
            ->orderBy('numero_parcela')
            ->get();

        $this->assertEquals(1, $parcelas[0]->numero_parcela);
        $this->assertEquals(2, $parcelas[1]->numero_parcela);
        $this->assertEquals(3, $parcelas[2]->numero_parcela);
    }

    public function test_sends_email_with_parcelas(): void
    {
        Mail::fake();

        $cliente = Cliente::factory()->create(['email' => 'teste@example.com']);
        $banco = Banco::factory()->create();

        $servico = ServicoCobranca::create([
            'nome_servico' => 'Serviço de Teste',
            'valor_total' => 1000.00,
            'quantidade_parcelas' => 2,
            'cliente_id' => $cliente->id,
            'banco_id' => $banco->id,
            'parcelas_geradas' => false,
        ]);

        $job = new GerarParcelasEEnviarEmail($servico);
        $job->handle();

        // Verifica se Mail::send foi chamado (verifica que não está vazio)
        // Mail::send() não cria um mailable, então verificamos indiretamente
        // através das parcelas marcadas como enviadas
        $parcelas = Parcela::where('servico_cobranca_id', $servico->id)->get();

        // Se as parcelas foram marcadas como enviadas, o email foi processado
        foreach ($parcelas as $parcela) {
            $parcela->refresh();
            $this->assertTrue($parcela->enviado_email, 'Parcela deve estar marcada como enviada');
            $this->assertNotNull($parcela->enviado_em, 'Data de envio deve estar preenchida');
        }

        // Verifica que pelo menos uma parcela foi enviada
        $this->assertGreaterThan(0, $parcelas->where('enviado_email', true)->count());
    }

    public function test_does_not_regenerate_parcelas_if_already_generated(): void
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $banco = Banco::factory()->create();

        $servico = ServicoCobranca::create([
            'nome_servico' => 'Serviço de Teste',
            'valor_total' => 1000.00,
            'quantidade_parcelas' => 5,
            'cliente_id' => $cliente->id,
            'banco_id' => $banco->id,
            'parcelas_geradas' => true, // Já gerado
        ]);

        // Cria uma parcela manualmente
        Parcela::create([
            'servico_cobranca_id' => $servico->id,
            'numero_parcela' => 1,
            'valor' => 200.00,
            'data_vencimento' => now()->addMonth(),
            'enviado_email' => false,
        ]);

        $initialCount = Parcela::where('servico_cobranca_id', $servico->id)->count();

        $job = new GerarParcelasEEnviarEmail($servico);
        $job->handle();

        // Verifica que não criou novas parcelas
        $finalCount = Parcela::where('servico_cobranca_id', $servico->id)->count();
        $this->assertEquals($initialCount, $finalCount);
    }

    public function test_calculates_parcela_value_correctly(): void
    {
        Mail::fake();

        $cliente = Cliente::factory()->create();
        $banco = Banco::factory()->create();

        // Testa com valor que não divide igualmente
        $servico = ServicoCobranca::create([
            'nome_servico' => 'Serviço de Teste',
            'valor_total' => 100.00,
            'quantidade_parcelas' => 3, // 100 / 3 = 33.33...
            'cliente_id' => $cliente->id,
            'banco_id' => $banco->id,
            'parcelas_geradas' => false,
        ]);

        $job = new GerarParcelasEEnviarEmail($servico);
        $job->handle();

        $parcelas = Parcela::where('servico_cobranca_id', $servico->id)->get();

        // Verifica que o valor foi arredondado para 2 casas decimais
        foreach ($parcelas as $parcela) {
            $this->assertEquals(33.33, (float) $parcela->valor);
        }

        // Soma das parcelas deve ser aproximadamente o valor total
        // Nota: Devido ao arredondamento, pode haver pequena diferença
        $total = $parcelas->sum(fn($p) => (float) $p->valor);
        $this->assertGreaterThanOrEqual(99.99, $total);
        $this->assertLessThanOrEqual(100.01, $total);
    }
}
