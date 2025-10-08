<?php

namespace App\Repositories;

use App\Http\Requests\Auth\LoginRequest;
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

    /**
     * @param array{
     *     email: string,
     *     password: string
     * } $data
     * @return User
     */
    public function getOrCreate(array $data): User
    {
        return User::createOrFirst($data);
    }
}
