<?php

namespace App\DTOs;

use App\Models\Paste;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Dto;

class LatestPastesDTO extends Dto
{
    /**
     * @param  array<PasteDTO>  $latestPastes
     */
    public function __construct(
        public readonly array $latestPastes,
    ) {}

    /**
     * @param  Collection<string, Paste>  $pastes
     */
    public static function fromArray(Collection $pastes): self
    {
        $latestPastes = $pastes->mapInto(PasteDTO::class)->values()->toArray();

        return new self($latestPastes);
    }
}
