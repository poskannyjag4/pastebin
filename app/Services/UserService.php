<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * @throws \Exception
     * @throws ModelNotFoundException<User>
     */
    public function ban(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->is_banned = true;

        if (! $user->save()) {
            throw new \Exception('Произошла ошибка!');
        }
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function getUsers(): LengthAwarePaginator
    {
        return User::paginate(15);
    }

    public function generateToken(User $user): string
    {
        if (! is_null($user->tokens) && $user->tokens->where('name', 'access_token')->count() != 0) {
            $user->tokens()->where('name', 'access_token')->delete();
        }

        return $user->createToken('access_token')->plainTextToken;
    }
}
