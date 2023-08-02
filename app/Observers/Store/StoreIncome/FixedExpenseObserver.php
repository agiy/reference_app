<?php

declare(strict_types=1);

namespace App\Observers\Store\StoreIncome;

use App\Models\Store\StoreIncome\FixedExpense;
use DomainException;

final class FixedExpenseObserver
{
    public function deleting(FixedExpense $fixedExpense): void
    {
        // アプリケーション都合上、必ず制御したい重要な制約に関してはObserverを利用し制御する
    }
}
