<?php

namespace App\Repositories;

use Laravel\Sanctum\PersonalAccessToken;
use Prettus\Repository\Eloquent\BaseRepository;

class PersonalAccessTokenRepository extends BaseRepository
{
    /**
     * {@inheritDoc}
     */
    public function model()
    {
        return PersonalAccessToken::class;
    }
}
