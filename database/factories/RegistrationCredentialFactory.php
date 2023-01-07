<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RegistrationCredentialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => Str::random(8),
            'is_active' => $this->faker->boolean(),
            'role_id' => $this->faker->numberBetween(1, 5),
            'organization_id' => $this->faker->numberBetween(1, 9),
            'limit' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
