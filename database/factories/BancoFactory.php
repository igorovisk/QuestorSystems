<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banco>
 */
class BancoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Gera código de banco único de 3 dígitos (000-999)
        // Usa unique() para garantir que não repita
        $codigoBanco = str_pad((string) fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT);

        return [
            'nome_banco' => fake()->company() . ' Banco',
            'codigo_banco' => $codigoBanco,
            'percentual_juros' => fake()->randomFloat(2, 1.0, 5.0),
        ];
    }
}
