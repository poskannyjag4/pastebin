<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
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
     * @return bool
     */
    public function ban(int $userId): bool{
       if($this->userRepository->ban($userId)){
           return true;
       }
       return false;
    }

    /**
     * @return LengthAwarePaginator<int, User>
     */
    public function getUsers(): LengthAwarePaginator
    {
        return $this->userRepository->getUsers();
    }
}
