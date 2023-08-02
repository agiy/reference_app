<?php

declare(strict_types=1);

namespace App\Http\Controllers\Setting\Store\StoreIncome\FixedExpense;

use App\Exceptions\ResourceNotDeletableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccount\Setting\Store\StoreIncome\FixedExpense\FixedExpenseRequest;
use App\Http\Resources\Store\StoreIncome\FixedExpenseResource;
use App\Models\Store\StoreAccount;
use App\Models\Store\StoreIncome\FixedExpense;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Controllerはできるだけ見通しを良くしたいので複雑な処理が必要となったらServiceやUseCaseに処理を委譲するなどを検討
 * そうすることで特定のAPIの処理ケースが増えた際にはServiceやUseCaseの単体テストとしてテストを分けることができる
 *
 * Laravel標準のindexやstoreなどのCRUD APIは1つのControllerにまとめるが、
 * それ以外はシングルアクションControllerとして実装している
 */
final class FixedExpenseController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        /** @var StoreAccount $storeAccount */
        $storeAccount = auth()->user();

        $fixedExpenses = FixedExpense::whereStoreId($storeAccount->store_id)->get();

        return FixedExpenseResource::collection($fixedExpenses);
    }

    public function store(FixedExpenseRequest $request): FixedExpenseResource
    {
        /** @var StoreAccount $storeAccount */
        $storeAccount = auth()->user();

        $validated = $request->validated();
        assert(is_array($validated));

        $fixedExpense = $storeAccount->store->fixedExpenses()->create($validated);

        return new FixedExpenseResource($fixedExpense);
    }

    public function update(FixedExpenseRequest $request, FixedExpense $fixedExpense): FixedExpenseResource
    {
        // クライアントが指定したResource($fixedExpense)に権限があるかの認可
        $this->authorize('authorityAsStoreAccount', $fixedExpense->store); // このRepositoryではPolicy自体は未実装

        $validated = $request->validated();
        assert(is_array($validated));

        $fixedExpense->update($validated);

        return new FixedExpenseResource($fixedExpense);
    }

    /**
     * @param FixedExpense $fixedExpense
     * @throws ResourceNotDeletableException
     * @return JsonResponse
     */
    public function destroy(FixedExpense $fixedExpense): JsonResponse
    {
        $this->authorize('authorityAsStoreAccount', $fixedExpense->store); // このRepositoryではPolicy自体は未実装

        try {
            $fixedExpense->delete();
        } catch (DomainException $domainException) {
            throw new ResourceNotDeletableException($domainException->getMessage());
        }

        return response()->json(['id' => $fixedExpense->id]);
    }
}
