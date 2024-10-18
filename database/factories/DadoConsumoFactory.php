<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DadoConsumo>
 */
class DadoConsumoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = DadoConsumo::class;

    public function definition()
    {
        return [
            'data_hora' => $this->faker->dateTimeBetween('2024-09-01', '2024-09-30'), // Data em setembro de 2024
            'nivel' => $this->faker->numberBetween(0, 1000), // Nível entre 0 e 1000
            'tanque_id' => null, // Será definido mais tarde
        ];
    }
}
