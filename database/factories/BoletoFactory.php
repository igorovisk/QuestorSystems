<?php

namespace Database\Factories;

use App\Models\Banco;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boleto>
 */
class BoletoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Gera CPF aleatório (11 dígitos)
        $cpf = str_pad((string) fake()->numberBetween(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);

        // Gera CNPJ aleatório (14 dígitos)
        $cnpj = str_pad((string) fake()->numberBetween(10000000000000, 99999999999999), 14, '0', STR_PAD_LEFT);

        return [
            'nome_pagador' => fake()->name(),
            'cpf_cnpj_pagador' => $cpf,
            'nome_beneficiario' => fake()->company(),
            'cpf_cnpj_beneficiario' => $cnpj,
            'valor' => fake()->randomFloat(2, 100.00, 10000.00),
            'data_vencimento' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'observacao' => fake()->optional()->sentence(),
            'banco_id' => Banco::factory(),
            'cliente_id' => Cliente::factory(),
        ];
    }
}
