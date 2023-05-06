<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::first(),
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'due_date' => $this->faker->date(),
        ];
    }
}
