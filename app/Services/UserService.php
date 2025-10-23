<?php

namespace App\Services;

use App\DTOs\ApiLoginDTO;
use App\DTOs\UserDTO;
use App\Http\Resources\LoginResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;
use Illuminate\Support\Facades\Hash;

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

    
    public function generateToken(User $user): void{

        if($user->tokens->where('name', 'access_token')->count() !=0){
            $user->tokens();
        }
        $user->createToken('accesss_token');
        return;
    }

    public function getUserByLogin(ApiLoginDTO $data){
         $user = User::whereEmail($data->email)->first();

         
        if(is_null($user)){
            throw new Exception('Пользователь не найден!');
        }

        if($data->password != $user->password){
            throw new Exception('Пользователь не найден!');
        }
        
        return $user;
    }
}
