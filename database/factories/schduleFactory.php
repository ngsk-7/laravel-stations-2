<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class schduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'movie_id' => $this->faker->numberBetween($min = 1, $max = 1),
            'start_time' => $this->faker->dateTimeBetween('1day', '1year')->format('H:i'),
            'end_time' => $this->faker->dateTimeBetween('1day', '1year')->format('H:i'),
            //
        ];
    }
}
