<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;
use Illuminate\Support\Facades\Hash;

class UserService
{

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
        return User::paginate(15);
    }

    /**
     * @param User $user
     * @return string
     */
    public function generateToken(User $user): string
    {


        if($user->tokens->where('name', 'access_token')->count() !=0){
           $user->tokens()->where('name', 'access_token')->delete();
        }
        return $user->createToken('access_token')->plainTextToken;
    }


}
