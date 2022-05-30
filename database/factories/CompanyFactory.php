<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'user_id' => "int",
        'title' => "string",
        'description' => "string",
        'phone' => "string"
    ])]
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->company(),
            'description' => $this->faker->text(),
            'phone' => $this->faker->phoneNumber()
        ];
    }
}
