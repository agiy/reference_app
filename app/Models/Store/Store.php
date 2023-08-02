<?php

declare(strict_types=1);

namespace App\Models\Store;

use App\Models\Store\StoreIncome\FixedExpense;
use Database\Factories\Store\StoreFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Store\Store
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, FixedExpense> $fixedExpenses
 * @property-read int|null $base_prices_count
 * @property-read int|null $casts_count
 * @property-read int|null $custom_status_groups_count
 * @property-read int|null $events_count
 * @property-read int|null $plans_count
 * @property-read int|null $queue_numbers_count
 * @property-read int|null $rooms_count
 * @method static StoreFactory factory(...$parameters)
 * @method static Builder|Store newModelQuery()
 * @method static Builder|Store newQuery()
 * @method static Builder|Store query()
 * @method static Builder|Store whereCreatedAt($value)
 * @method static Builder|Store whereId($value)
 * @method static Builder|Store whereName($value)
 * @method static Builder|Store whereUpdatedAt($value)
 * @mixin Eloquent
 */
final class Store extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    // //////////////////////////////////////
    // Relations
    // //////////////////////////////////////

    /**
     * @return HasMany<FixedExpense>
     */
    public function fixedExpenses(): HasMany
    {
        return $this->hasMany(FixedExpense::class);
    }
}
