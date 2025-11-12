<?php

namespace App\Services;

use App\DTOs\UserDataFromSocialDTO;
use App\DTOs\UserSocialCreationDTO;
use App\Models\User;
use App\Repositories\PersonalAccessTokenRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserSocialRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Validator\Exceptions\ValidatorException;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserSocialRepository $userSocialRepository,
        private PersonalAccessTokenRepository $personalAccessTokenRepository
    ) {}

    /**
     * @throws \Exception
     */
    public function ban(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if (is_null($user)) {
            throw new ModelNotFoundException;
        }
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
        return $this->userRepository->getPaginated();
    }

    public function generateToken(User $user): string
    {
        $userTokens = $this->personalAccessTokenRepository->findWhere([
            'tokenable_id' => $user->id,
            'name' => 'access_token',
        ]);
        if ($userTokens->count() != 0) {
            foreach ($userTokens as $userToken) {
                $this->personalAccessTokenRepository->delete($userToken->id);
            }
        }

        return $user->createToken('access_token')->plainTextToken;
    }

    /**
     * @throws ValidatorException
     */
    public function findOrCreateUserForSocials(UserDataFromSocialDTO $data): User
    {
        $user = $this->userRepository->findWhere(['email' => $data->email]);

        if (is_null($user)) {
            return $this->userRepository->create([
                'email' => $data->email,
                'name' => $data->name,
            ]);
        }

        return $user;
    }

    /**
     * @throws ValidatorException
     */
    public function createAndAttachUserSocial(UserSocialCreationDTO $data, int $userId): void
    {
        $userSocial = $this->userSocialRepository->findWhere(['provider_id' => $data->providerId]);
        if (! is_null($userSocial)) {
            return;
        }
        $this->userSocialRepository->create([
            'provider_id' => $data->providerId,
            'provider_name' => $data->providerName,
            'user_id' => $userId,
        ]);
    }
}
