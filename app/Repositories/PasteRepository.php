<?php

namespace App\Repositories;

use App\Enums\LanguageEnum;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
/**
 * @phpstan-type PasteCreationData array{
 * title: string,
 * text: string,
 * visibility: VisibilityEnum|string,
 * expires_at: Carbon|null,
 * programming_language: LanguageEnum|string
 * }
 */
class PasteRepository
{
    /**
     * @return Collection|Paste[]
     */
    public function getLatestPastes(): Collection
    {
        return Paste::where('expires_at', '>', Carbon::now())->orWhere('expires_at', '=', null)->latest()->take(10)->get();
    }

    /**
     * @param int $userId
     * @return Collection|Paste[]
     */
    public function getLatestUserPastes(int $userId): Collection
    {
        return Paste::where('user_id', '=', $userId)->where('expires_at', '>', Carbon::now())->latest()->take(10)->get();
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
     * @return Paste
     */
    public function get(int $id): Paste{
        return Paste::find($id);
    }
}
