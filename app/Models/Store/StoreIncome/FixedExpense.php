<?php

declare(strict_types=1);

namespace App\Models\Store\StoreIncome;

use App\Enums\Common\EnabledStatus;
use App\Models\Store\Store;
use Carbon\CarbonImmutable;
use Database\Factories\Store\StoreIncome\FixedExpenseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Store\StoreIncome\FixedExpense
 *
 * @property int $id
 * @property int $store_id
 * @property string $name
 * @property int $default_amount フォーム入力時の初期値として利用する
 * @property EnabledStatus $status
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Store $store
 * @method static FixedExpenseFactory factory($count = null, $state = [])
 * @method static Builder|FixedExpense newModelQuery()
 * @method static Builder|FixedExpense newQuery()
 * @method static Builder|FixedExpense query()
 * @method static Builder|FixedExpense whereCreatedAt($value)
 * @method static Builder|FixedExpense whereDefaultAmount($value)
 * @method static Builder|FixedExpense whereId($value)
 * @method static Builder|FixedExpense whereName($value)
 * @method static Builder|FixedExpense whereStatus($value)
 * @method static Builder|FixedExpense whereStoreId($value)
 * @method static Builder|FixedExpense whereUpdatedAt($value)
 * @method static Builder|FixedExpense Enabled()
 * @mixin Eloquent
 */
final class FixedExpense extends Model
{
    use HasFactory;

    protected $table = 'store_income_fixed_expenses';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'status' => EnabledStatus::class,
    ];

    // //////////////////////////////////////
    // Relations
    // //////////////////////////////////////

    /**
     * @return BelongsTo<Store, FixedExpense>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // //////////////////////////////////////
    // Scopes
    // //////////////////////////////////////

    /**
     * @param Builder<FixedExpense> $query
     * @return Builder<FixedExpense>
     */
    public function scopeEnabled(Builder $query): Builder
    {
        return $query->where('status', EnabledStatus::ENABLED->value);
    }
}
