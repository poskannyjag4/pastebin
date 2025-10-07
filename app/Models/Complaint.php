<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * @property-read \App\Models\Paste|null $paste
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Complaint query()
 * @mixin \Eloquent
 */
class Complaint extends Model
{
    use AsSource;

    protected $table = 'complaints';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Paste, $this>
     */
    public function paste(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\Paste', 'paste_id');
    }

    protected $fillable = ['user_id', 'details', 'paste_id'];
}
