<?php

namespace App\Repositories;

use App\Models\Paste;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PasteRepository
{
    /**
     * @return Collection|Paste[]
     */
    public function getLatestPastes(): Collection
    {
        $pastes = Paste::where('expires_at', '>', Carbon::now())->latest()->take(10)->get();
        return $pastes;
    }

    /**
     * @param int $userId
     * @return Collection|Paste[]
     */
    public function getLatestUserPastes(int $userId): Collection
    {
        $pastes = Paste::where('user_id', '=', $userId)->where('expires_at', '>', Carbon::now())->latest()->take(10)->get();
        return $pastes;
    }
}
