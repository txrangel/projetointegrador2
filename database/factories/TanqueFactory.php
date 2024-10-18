<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tanque>
 */
class TanqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tanque::class;    
    public function definition(): array
    {
        return [
            'planta_id' => $this->faker->numberBetween(3,4), // Supondo que você tenha plantas com IDs de 1 a 10
            'maximo' => $this->faker->numberBetween(500, 1500),
            'minimo' => $this->faker->numberBetween(0, 500),
            'unidade_de_medida_id' => $this->faker->numberBetween(5, 6), // Supondo que você tenha unidades com IDs de 1 a 5
        ];
    }
}
