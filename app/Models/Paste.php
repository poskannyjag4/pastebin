<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paste extends Model
{
    //

    /**
     *
     *
     * @return BelongsTo<User>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    protected $table = 'pastes';

    protected $fillable = ['users_id', 'text', 'expires_at', 'visibility'];

}
