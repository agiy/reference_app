<?php

declare(strict_types=1);

namespace Tests\Traits\Store;

use App\Models\Store\Store;
use App\Models\Store\StoreAccount;

trait CreatesStoreAccount
{
    protected function createStoreAccount(Store $store, array $attributes = []): StoreAccount
    {
        $attributes['store_id'] = $store->id;

        return StoreAccount::factory()->create($attributes);
    }
}
