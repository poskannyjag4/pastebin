<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class UserService
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param int $userId
     * @return void
     * @throws \Exception
     * @throws ModelNotFoundException<User>
     */
    public function ban(int $userId): void{
           $user = User::findOrFail($userId);

           $user->is_banned = true;
           if(!$user->save()){
               throw new \Exception("Произошла ошибка!");
           }
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function getUsers(): LengthAwarePaginator
    {
        return $this->userRepository->getUsers();
    }
}
