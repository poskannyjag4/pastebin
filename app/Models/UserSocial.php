<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial query()
 * @property int $id
 * @property string|null $provider_name
 * @property string|null $provider_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial whereProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSocial whereUserId($value)
 * @mixin \Eloquent
 */
class UserSocial extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = ['provider_name', 'provider_id', 'user_id'];

    protected $table = 'user_socials';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
