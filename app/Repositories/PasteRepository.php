<?php

namespace App\Repositories;

use App\Enums\LanguageEnum;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\UuidInterface;

/**
 * @phpstan-type PasteCreationData array{
 * title: string,
 * text: string,
 * visibility: VisibilityEnum|string,
 * expires_at: Carbon|null,
 * programming_language: LanguageEnum|string,
 * token: UuidInterface|null
 * }
 */
class PasteRepository
{
    /**
     * Возвращает 10 последних паст
     *
     * @return Collection|Paste[]
     */
    public function getLatestPastes(): Collection
    {
        return Paste::where(function ($query){
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        })->where('visibility', '=', VisibilityEnum::public->name)->latest()->take(10)->get();
    }

    /**
     * Возвращает 10 последних паст текущего пользователя
     *
     * @param int $userId
     * @return Collection|Paste[]
     */
    public function getLatestUserPastes(int $userId): Collection
    {
        return Paste::where('user_id', '=', $userId)->where(function ($query){
            $query->where('expires_at', '>', Carbon::now())
                ->orWhere('expires_at', '=', null);
        })->latest()->take(10)->get();
    }

    /**
     * @param PasteCreationData $data
     * @param ?User $user
     * @return Paste
     */
    public function create(array $data, ?User $user): Paste
    {
        if(is_null($user)){
            return Paste::create($data);
        }
        return $user->pastes()->create($data);

    }

    /**
     * @param int $id
     * @return Paste|null
     */
    public function get(int $id): Paste|null
    {
        return Paste::find($id);
    }

    /**
     * @param string $token
     * @return Paste|null
     */
    public function getByToken(string $token): Paste|null
    {
        return Paste::where('token', '=', $token)->first();
    }
}
