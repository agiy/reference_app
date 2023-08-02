<?php

declare(strict_types=1);

namespace Database\Factories\Store;

use App\Models\Store\StoreAccount;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<StoreAccount>
 */
final class StoreAccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email'             => $this->faker->unique()->safeEmail(),
            'email_verified_at' => CarbonImmutable::now(),
            'password'          => bcrypt('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * @return Factory<StoreAccount>
     */
    public function unverified(): Factory
    {
        return $this->state(static function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
