<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\PasteFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $text
 * @property Carbon $expires_at
 * @property string $visibility
 * @property string $programming_language
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PasteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereProgrammingLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Paste whereUserId($value)
 * @mixin \Eloquent
 */
class Paste extends Model
{

    /** @use HasFactory<\Database\Factories\PasteFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @var string
     */
    protected $table = 'pastes';
    /**
     * @var list<string>
     */
    protected $fillable = ['user_id', 'title', 'text', 'expires_at', 'visibility', 'programming_language'];

}
