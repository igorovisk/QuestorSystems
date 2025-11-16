<?php

namespace App\Jobs;

use App\Models\Parcela;
use App\Models\ServicoCobranca;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GerarParcelasEEnviarEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly ServicoCobranca $servicoCobranca
    ) {}

    public function handle(): void
    {
        // Recarrega o model com relacionamentos
        $this->servicoCobranca->refresh();
        $this->servicoCobranca->load(['cliente', 'banco']);

        // Verifica se as parcelas já foram geradas
        if ($this->servicoCobranca->parcelas_geradas) {
            return;
        }

        // Calcula valor por parcela
        $valorParcela = $this->servicoCobranca->valor_total / $this->servicoCobranca->quantidade_parcelas;
        $valorParcela = round($valorParcela, 2);

        // Gera as parcelas
        $parcelas = [];
        $dataBase = now()->addMonth();

        for ($i = 1; $i <= $this->servicoCobranca->quantidade_parcelas; $i++) {
            $parcela = Parcela::create([
                'servico_cobranca_id' => $this->servicoCobranca->id,
                'numero_parcela' => $i,
                'valor' => $valorParcela,
                'data_vencimento' => $dataBase->copy()->addMonths($i - 1)->format('Y-m-d'),
                'enviado_email' => false,
            ]);

            $parcelas[] = $parcela;
        }

        // Marca como geradas
        $this->servicoCobranca->update(['parcelas_geradas' => true]);

        // Envia email com todas as parcelas
        $this->enviarEmail($parcelas);
    }

    private function enviarEmail(array $parcelas): void
    {
        $cliente = $this->servicoCobranca->cliente;
        $servico = $this->servicoCobranca;

        Mail::send('emails.parcelas', [
            'cliente' => $cliente,
            'servico' => $servico,
            'parcelas' => $parcelas,
        ], function ($message) use ($cliente) {
            $message->to($cliente->email, $cliente->nome)
                ->subject('Parcelas do Serviço de Cobrança');
        });

        // Marca parcelas como enviadas
        foreach ($parcelas as $parcela) {
            $parcela->update([
                'enviado_email' => true,
                'enviado_em' => now(),
            ]);
        }
    }
}
