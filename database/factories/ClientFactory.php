<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ClientFactory extends Factory
{

    private function getAddress()
    {
        $addresses = [
            [
                'endereco' => 'Rua Fictícia, '.mt_rand(1, 500),
                'cidade' => 'Sales',
                'estado' => 'SP'
            ],
            [
                'endereco' => 'Avenida Imaginária, 456'.mt_rand(1, 500),
                'cidade' => 'Areal',
                'estado' => 'RJ'
            ],
            [
                'endereco' => 'Travessa Inventada, 789'.mt_rand(1, 500),
                'cidade' => 'Rubim',
                'estado' => 'MG'
            ]
        ];
        $randomIndex = array_rand($addresses);
        $randomAddress = $addresses[$randomIndex];
        return $randomAddress;
    }

    private function generateBirthdate()
    {
        $day = mt_rand(1, 28);
        $month = mt_rand(1, 12);
        $year = mt_rand(1950, 2005);
    
        return sprintf('%02d/%02d/%04d', $day, $month, $year);
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $Address = $this->getAddress();
        return [
            'name' => fake()->name(),
            'date_birth' => $this->generateBirthdate(),
            'sex' => ['M', 'F'][array_rand(['M', 'F'])],
            'cpf' => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-' . rand(10, 99) . '',
            'address' => $Address['endereco'],
            'city' => $Address['cidade'],
            'state' => $Address['estado'],
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
