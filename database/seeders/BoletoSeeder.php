<?php

namespace Database\Seeders;

use App\Models\Banco;
use App\Models\Boleto;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class BoletoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Usa Factory para popular o banco com dados aleatórios.
     */
    public function run(): void
    {
        // Garante que existam clientes e bancos
        $clientes = Cliente::all();
        $bancos = Banco::all();

        if ($clientes->isEmpty() || $bancos->isEmpty()) {
            $this->command->warn('Certifique-se de que ClienteSeeder e BancoSeeder foram executados primeiro!');

            return;
        }

        // Cria 30 boletos usando a Factory
        // Usa clientes e bancos existentes para manter relacionamentos consistentes
        for ($i = 0; $i < 30; $i++) {
            Boleto::factory()->create([
                'cliente_id' => $clientes->random()->id,
                'banco_id' => $bancos->random()->id,
            ]);
        }
    }
}
