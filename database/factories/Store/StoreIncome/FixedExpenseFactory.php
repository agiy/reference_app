<?php

declare(strict_types=1);

namespace Database\Factories\Store\StoreIncome;

use App\Models\Store\StoreIncome\FixedExpense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FixedExpense>
 */
final class FixedExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'           => $this->faker->word,
            'default_amount' => $this->faker->numberBetween(100, 1000),
        ];
    }
}
