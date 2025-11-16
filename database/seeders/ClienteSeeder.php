<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Usa Factory para popular o banco com dados aleatórios.
     */
    public function run(): void
    {
        // Cria 20 clientes usando a Factory
        Cliente::factory(20)->create();
    }
}
