<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\StoreAccount\Setting\Store\StoreIncome\FixedExpense;

use App\Enums\Common\EnabledStatus;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Feature\Http\Controllers\TestCase;
use Tests\Traits\Store\CreatesStore;
use Tests\Traits\Store\CreatesStoreAccount;
use Tests\Traits\Store\StoreIncome\CreatesFixedExpense;

/**
 * 結合テストとしてAPIのテストを実施
 *
 * routeの設定をしていないのでこのテストは実行不可
 */
final class FixedExpenseControllerTest extends TestCase
{
    // テスト用のDBを用意し、Traitを使ってModelを生成しテストする
    use DatabaseTransactions;
    use CreatesStoreAccount;
    use CreatesStore;
    use CreatesFixedExpense;

    public function testIndex(): void
    {
        // Arrange
        $store        = $this->createStore();
        $storeAccount = $this->createStoreAccount($store);

        $fixedExpense = $this->createFixedExpense($store);
        $fixedExpense->refresh();

        // 無効
        $disabledFixedExpense = $this->createFixedExpense($store, ['status' => EnabledStatus::DISABLED->value]);

        // 他会社のfixedExpense(返ってこない)
        $creteOtherStoreFixedExpense = function (): void {
            $store = $this->createStore();
            $this->createFixedExpense($store);
        };
        $creteOtherStoreFixedExpense();

        // Act
        $this->actingAsStoreAccount($storeAccount);
        $response = $this->getJson('/web/store-accounts/settings/stores/store-incomes/fixed-expenses');

        // Assert
        // クライアントが必要としているレスポンスが返ることを確認する
        // ここで確認されないと、APIの仕様変更によりクライアントが正しく動作しなくなる可能性がある
        $response->assertOk()->assertJson([
            [
                'id'             => $fixedExpense->id,
                'store_id'       => $fixedExpense->store_id,
                'name'           => $fixedExpense->name,
                'default_amount' => $fixedExpense->default_amount,
                'status'         => $fixedExpense->status->value,
            ],
            ['id' => $disabledFixedExpense->id]
        ])->assertJsonCount(2); // assertJsonCountにて他会社のfixedExpenseが返ってこないことを確認している
    }

    public function testStore(): void
    {
        // Arrange
        $store        = $this->createStore();
        $storeAccount = $this->createStoreAccount($store);

        $params = [
            'name'           => 'test name',
            'default_amount' => 1000,
            'status'         => EnabledStatus::ENABLED->value,
        ];

        // Act
        $this->actingAsStoreAccount($storeAccount);
        $response = $this->postJson('/web/store-accounts/settings/stores/store-incomes/fixed-expenses', $params);

        // Assert
        // このAPIに期待する動作は2つ
        // 1.リクエストした内容でFixedExpenseが作成されること
        // 2.その結果が返ってくること
        // そのためレスポンスとDBの内容をチェックしている
        $response->assertCreated()->assertJson([
            'store_id'       => $storeAccount->store_id,
            'name'           => $params['name'],
            'default_amount' => $params['default_amount'],
            'status'         => $params['status'],
        ]);

        $this->assertDatabaseHas('store_income_fixed_expenses', [
            'store_id'       => $storeAccount->store_id,
            'name'           => $params['name'],
            'default_amount' => $params['default_amount'],
            'status'         => $params['status'],
        ]);
    }

    public function testUpdate(): void
    {
        // Arrange
        $store        = $this->createStore();
        $storeAccount = $this->createStoreAccount($store);

        $fixedExpense = $this->createFixedExpense($store);

        $params = [
            'name'           => 'test name',
            'default_amount' => 1000,
            'status'         => EnabledStatus::ENABLED->value,
        ];

        // Act
        $this->actingAsStoreAccount($storeAccount);
        $response = $this->patchJson("/web/store-accounts/settings/stores/store-incomes/fixed-expenses/$fixedExpense->id", $params);

        // Assert
        // このAPIに期待する動作は2つ
        // 1.リクエストした内容でFixedExpenseが更新されること
        // 2.その結果が返ってくること
        // そのためレスポンスとDBの内容をチェックしている
        $response->assertOk()->assertJson([
            'id'             => $fixedExpense->id,
            'store_id'       => $storeAccount->store_id,
            'name'           => $params['name'],
            'default_amount' => $params['default_amount'],
            'status'         => $params['status'],
        ]);

        $this->assertDatabaseHas('store_income_fixed_expenses', [
            'id'             => $fixedExpense->id,
            'store_id'       => $storeAccount->store_id,
            'name'           => $params['name'],
            'default_amount' => $params['default_amount'],
            'status'         => $params['status'],
        ]);
    }

    public function testDestroy(): void
    {
        // Arrange
        $store        = $this->createStore();
        $storeAccount = $this->createStoreAccount($store);

        $fixedExpense = $this->createFixedExpense($store);

        // Act
        $this->actingAsStoreAccount($storeAccount);
        $response = $this->deleteJson("/web/store-accounts/settings/stores/store-incomes/fixed-expenses/$fixedExpense->id");

        // Assert
        $response->assertOk()->assertJson([
            'id' => $fixedExpense->id,
        ]);

        $this->assertDatabaseMissing('store_income_fixed_expenses', [
            'id' => $fixedExpense->id,
        ]);
    }

    /**
     * 今回はObserverにdelete時の制御を付与していないためテストは不要
     * 仮に付与した場合は制御されていることを確認するテストを書く。
     * Observer自体への単体テストでもいいが、より確実なのはAPIを使った結合テスト。
     * 例えばObserverの処理に多くのケースが必要な場合は、
     * APIのテストなどでObserverが効いていることを確認しつつ、
     * 他の多くのテストケースをObserverの単体テストでカバーするなどの方法が考えられる
     *
     * @return void
     */
    public function testDestroyUsedCastSalary(): void
    {
        // Arrange
        $store        = $this->createStore();
        $storeAccount = $this->createStoreAccount($store);

//        $storeIncome  = $this->createStoreIncome($store); //TODO
        $fixedExpense = $this->createFixedExpense($store);

        // Act
        $this->actingAsStoreAccount($storeAccount);
        $response = $this->deleteJson("/web/store-accounts/settings/stores/store-incomes/fixed-expenses/$fixedExpense->id");

        // Assert
        $response->assertConflict()->assertJson([
            'message' => '過去の店舗収益にて固定費用が利用されているため削除できません。不要になった場合は無効にしてください。',
        ]);

        //この制御で大事なのは$fixedExpenseが削除されないことのため確認している
        $this->assertDatabaseHas('store_income_fixed_expenses', [
            'id' => $fixedExpense->id,
        ]);
    }
}
