<?php

declare(strict_types=1);

namespace App\Http\Resources\Store\StoreIncome;

use App\Models\Store\StoreIncome\FixedExpense;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin FixedExpense
 */
final class FixedExpenseResource extends JsonResource
{
    /**
     * クライアントに返すレスポンスの内容はPresenterとしてResourceを使って制御する
     *
     * Modelをそのまま返すとModelにプロパティが増えた場合などに意図せずクライアントにプロパティが渡ってしまう。
     * モバイルアプリなど後方互換性の維持が必要なクライアントがある場合は、一度プロパティを使われると安易に削除ができなくなるため。
     *
     * アクセサを返すケースなどでもController側にappendを書くなどせず、レスポンスの内容の責務はResourceが持ち、Resourceが制御すること
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'store_id'       => $this->store_id,
            'name'           => $this->name,
            'default_amount' => $this->default_amount,
            'status'         => $this->status->value,
        ];
    }
}
