<?php

namespace App\DTOs;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Dto;
use App\Models\Paste;

class LatestPastesDTO extends Dto
{
    /**
     * @param array<PasteDTO> $latestPastes
     */
    public function __construct (
        public readonly array $latestPastes,
    ){}

    /**
     * @param Collection<string, Paste> $pastes
     * @return LatestPastesDTO
     */
    public static function fromArray(Collection $pastes): self {
        $latestPastes = $pastes->mapInto(PasteDTO::class)->values()->toArray();

        return new self($latestPastes);
    }
}
