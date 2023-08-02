<?php

declare(strict_types=1);

namespace App\Models\Store;

use Carbon\CarbonImmutable;
use Database\Factories\Store\StoreAccountFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Store\StoreAccount
 *
 * @property int $id
 * @property int $store_id
 * @property string $email
 * @property CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Store $store
 * @property-read int|null $tokens_count
 * @method static Builder|StoreAccount newModelQuery()
 * @method static Builder|StoreAccount newQuery()
 * @method static Builder|StoreAccount query()
 * @method static Builder|StoreAccount whereCreatedAt($value)
 * @method static Builder|StoreAccount whereEmail($value)
 * @method static Builder|StoreAccount whereEmailVerifiedAt($value)
 * @method static Builder|StoreAccount whereId($value)
 * @method static Builder|StoreAccount wherePassword($value)
 * @method static Builder|StoreAccount whereRememberToken($value)
 * @method static Builder|StoreAccount whereStoreId($value)
 * @method static Builder|StoreAccount whereUpdatedAt($value)
 * @method static StoreAccountFactory factory($count = null, $state = [])
 * @mixin Eloquent
 */
final class StoreAccount extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<Store, StoreAccount>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
