<?php

namespace App\Repositories;

use App\Models\User;
use Throwable;

class UserRepository
{
    /**
     * @param int $userId
     * @return bool
     */
    public function ban(int $userId): bool
    {
        $user = User::where('id', $userId)->first();

        if(is_null($user)){
            return false;
        }
        if($user->is_banned){
            return true;
        }
        $user->is_banned = true;
        return $user->save();
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<int, User>
     */
    public function getUsers(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return User::paginate(15);
    }
}
