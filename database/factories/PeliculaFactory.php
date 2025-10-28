<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelicula>
 */
class PeliculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titol' => $this->faker->sentence(3), // títol de la pel·lícula
            'director' => $this->faker->name,
            'genere' => $this->faker->randomElement(['Acció', 'Comèdia', 'Drama', 'Ciència-ficció', 'Terror']),
            'any_estrena' => $this->faker->year,
            'duracio' => $this->faker->numberBetween(80, 180), // minuts
            'valoracio' => $this->faker->randomFloat(1, 0, 10), // nota de 0 a 10
        ];
    }
}
