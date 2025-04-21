<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    protected $model = Income::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // or use User::factory()->create()->id if you want auto-user
            'category_id' => $this->faker->numberBetween(1, 3),
            'amount' => $this->faker->numberBetween(1000, 10000),
            'description' => $this->faker->sentence(3),
            'created_at' => $this->faker->dateTimeBetween('-2 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
