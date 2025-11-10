<?php

namespace App\Repositories;

use App\Models\UserSocial;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSocialRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return UserSocial::class;
    }
}
