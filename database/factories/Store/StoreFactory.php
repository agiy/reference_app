<?php

declare(strict_types=1);

namespace Database\Factories\Store;

use App\Enums\Prefecture;
use App\Models\Store\Store;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
final class StoreFactory extends Factory
{
    protected $model = Store::class;

    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'name'          => $this->faker->name(),
            'zipcode'       => '123-4567',
            'prefecture'    => Prefecture::TOKYO->value,
            'address_line1' => $this->faker->address(),
            'address_line2' => $this->faker->address(),
            'phone_number'  => '0123-444-555',
            'memo'          => $this->faker->word(),
        ];
    }
}
