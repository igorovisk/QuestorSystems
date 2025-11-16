<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Usa Factory para popular o banco com dados aleatórios.
     */
    public function run(): void
    {
        // Cria 10 bancos usando a Factory
        Banco::factory(10)->create();
    }
}
