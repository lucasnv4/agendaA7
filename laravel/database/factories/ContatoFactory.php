<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contato;

class ContatoFactory extends Factory
{
    protected $model = Contato::class;

    public function definition(): array
    {
        return [
            'Nome' => $this->faker->name(),
            'Email' => $this->faker->unique()->safeEmail(),
            'Endereco' => $this->faker->address(),
            'Telefone' => $this->faker->phoneNumber(),
        ];
    }
}
