<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

/**
 * @property-read \App\Models\Paste|null $paste
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint query()
 * @property int $id
 * @property string $details
 * @property int|null $user_id
 * @property int $paste_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint wherePasteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint whereUserId($value)
 * @mixin \Eloquent
 */
class Complaint extends Model
{
    use AsSource;

    protected $table = 'complaints';
    protected $fillable = ['user_id', 'details', 'paste_id'];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return BelongsTo<Paste, $this>
     */
    public function paste(): BelongsTo {
        return $this->belongsTo('App\Models\Paste', 'paste_id');
    }


}
