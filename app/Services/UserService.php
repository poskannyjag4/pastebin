<?php

namespace App\Services;

use App\DTOs\UserDataFromSocialDTO;
use App\DTOs\UserSocialCreationDTO;
use App\Models\User;
use App\Models\UserSocial;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserSocialRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService
{

    function __construct(
        private UserRepositoryInterface $userRepository,
        private UserSocialRepository $userSocialRepository,
    )
    {

    }
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

    /**
     * @param User $user
     * @return string
     */
    public function generateToken(User $user): string
    {
        if ($user->tokens->where('name', 'access_token')->count() != 0) {
            $user->tokens()->where('name', 'access_token')->delete();
        }

        return $user->createToken('access_token')->plainTextToken;
    }

    /**
     * @param UserDataFromSocialDTO $data
     * @return User
     */
    public function findOrCreateUserForSocials(UserDataFromSocialDTO $data): User{
        $user = $this->userRepository->findWhere(['email' => $data->email]);

        if(is_null($user)){
            return $this->userRepository->create([
                'email' => $data->email,
                'name' => $data->name,
            ]);
        }
        return $user;
    }

    /**
     * @param UserSocialCreationDTO $data,
     * @param int $userId
     * @return void
     * @throws ValidatorException
     */
    public function createAndAttachUserSocial(UserSocialCreationDTO $data, int $userId): void{
        $userSocial = $this->userSocialRepository->findWhere(['provider_id'=>$data->providerId]);
        if(!is_null($userSocial)){
            return;
        }
        $this->userSocialRepository->create([
            'provider_id'=>$data->providerId,
            'provider_name'=>$data->providerName,
            'user_id'=>$userId
        ]);
    }
}
