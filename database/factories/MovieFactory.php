<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(10),
            'image_url' => $this->faker->imageUrl(),
            'published_year' => $this->faker->numberBetween($min = 1900, $max = 2000),
            'is_showing' => $this->faker->numberBetween($min = 0, $max = 1),
            'description' => $this->faker->realText(20),
            'genre_id' => $this->faker->numberBetween($min = 1, $max = 1),
        ];
    }
}
