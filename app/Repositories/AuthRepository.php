<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    /**
     * @param string $provider
     * @param string $id
     * @return User|null
     */
    public function getSocialUser(string $provider, string $id): ?User
    {
        return User::where('provider_name', $provider)
            ->where('provider_id', $id)
            ->first();
    }
}
