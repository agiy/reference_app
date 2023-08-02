<?php

declare(strict_types=1);

namespace Tests\Traits\Store\StoreIncome;

use App\Models\Store\Store;
use App\Models\Store\StoreIncome\FixedExpense;

trait CreatesFixedExpense
{
    protected function createFixedExpense(Store $store, array $attributes = []): FixedExpense
    {
        $attributes['store_id'] = $store->id;

        return FixedExpense::factory()->create($attributes);
    }
}
