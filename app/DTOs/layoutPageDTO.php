<?php

namespace App\DTOs;

use App\Models\Paste;
use Illuminate\Database\Eloquent\Collection;
class layoutPageDTO
{
    /**
     * @param Collection<int, Paste> $latestPastes
     * @param Collection<int, Paste> $latestUserPastes
     */
    public function __construct(
        public Collection $latestPastes,
        public Collection $latestUserPastes
    )
    {
    }
}
