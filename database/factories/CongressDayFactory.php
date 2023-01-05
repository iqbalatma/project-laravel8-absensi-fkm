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
        $hDay = $this->faker->dateTimeBetween("-1 years", "now");
        return [
            'location' => $this->faker->address(),
            'h_day' => $hDay,
            'created_at' => $hDay,
            'updated_at' => $hDay,
        ];
    }
}
