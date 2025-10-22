<?php

namespace App\Services;

use App\DTOs\ApiLoginDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
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

    
    public function getToken(ApiLoginDTO $data): string{

        $user = User::whereEmail($data->email);

        if(is_null($user)){
            throw new Exception('Пользователь не найден!');
        }

        if(!\Hash::check($data->password, $user->password)){
            throw new Exception('Пользователь не найден!');
        }

        if($user->tokens->contains('access_token')){
            return $user->tokens['access_token'];
        }
        return $user->createToken('accesss_token')->plainTextToken;
    }
}
