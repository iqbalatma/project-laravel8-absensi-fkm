<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CongressDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'location' => $this->faker->name(),
            'h_day' => $this->faker->dateTime()
        ];
    }
}
