<?php

declare(strict_types=1);

namespace App\Http\Requests\StoreAccount\Setting\Store\StoreIncome\FixedExpense;

use App\Enums\Common\EnabledStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class FixedExpenseRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:32',
            'default_amount' => 'required|integer|between:-100000,100000',//アプリケーション上の制約はバリデーションで制御。重要な制御であればObserverにて制御する
            'status'         => ['required', Rule::in(EnabledStatus::getValues())],
        ];
    }
}
