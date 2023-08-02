<?php

declare(strict_types=1);

namespace Tests\Traits\Store;

use App\Models\Store\Store;

trait CreatesStore
{
    /**
     * テストで使用するModelはこのTraitを使って生成する
     * Modelの生成処理を集約するため。
     * ModelはMockせず、テスト用のDBを使ってテストしている。
     *
     * @param array $attributes
     * @return Store
     */
    protected function createStore(array $attributes = []): Store
    {
        return Store::factory()->create($attributes);
    }
}
