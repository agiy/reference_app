<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Store\StoreAccount;
use Tests\TestCase as Base;

abstract class TestCase extends Base
{
    public function actingAsStoreAccount(StoreAccount $storeAccount): self
    {
        $this->actingAs($storeAccount, 'store_account');

        return $this;
    }
}
