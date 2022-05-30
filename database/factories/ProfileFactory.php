<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'first_name' => "string",
        'last_name' => "string",
        'phone' => "string"
    ])]
    public function definition(): array
    {
       return [
           'first_name' => $this->faker->firstName(),
           'last_name' => $this->faker->lastName(),
           'phone' => $this->faker->phoneNumber()
       ];
    }
}
