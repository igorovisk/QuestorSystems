<?php

namespace App\Console\Commands;

use App\Jobs\GerarParcelasEEnviarEmail;
use App\Models\ServicoCobranca;
use Illuminate\Console\Command;

class EnviarEmailsParcelas extends Command
{
    protected $signature = 'parcelas:enviar-emails';

    protected $description = 'Envia emails com parcelas para clientes (executa à meia-noite)';

    public function handle(): int
    {
        $this->info('Buscando serviços de cobrança para gerar parcelas e enviar emails...');

        // Busca serviços que ainda não tiveram parcelas geradas
        // Estes serão processados à meia-noite conforme requisito
        $servicos = ServicoCobranca::where('parcelas_geradas', false)
            ->with(['cliente', 'banco'])
            ->get();

        if ($servicos->isEmpty()) {
            $this->info('Nenhum serviço encontrado para processar.');

            return Command::SUCCESS;
        }

        $this->info("Encontrados {$servicos->count()} serviço(s) para processar.");

        foreach ($servicos as $servico) {
            $this->info("Processando serviço: {$servico->nome_servico} - Cliente: {$servico->cliente->nome}");

            // Dispara o job para gerar parcelas e enviar email
            // O job será processado pelo Horizon imediatamente após ser enfileirado
            GerarParcelasEEnviarEmail::dispatch($servico);

            $this->info("Job disparado para o serviço ID: {$servico->id}");
        }

        $this->info('Todos os jobs foram disparados com sucesso!');

        return Command::SUCCESS;
    }
}
