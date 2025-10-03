<?php

namespace App\Services;

use App\Models\Paste;
use App\Repositories\PasteRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class PasteService
{
    /**
     * @param PasteRepository $pasteRepository
     */
    public function __construct(
        private readonly PasteRepository $pasteRepository,
    )
    {
    }

    /**
     * Собирает данные о последних постах для основного шаблона
     *
     * @return array{
     *  latestPastes: Collection<int, Paste>,
     *  latestUserPastes: Collection<int, Paste>|null
     *  }
     */
    public function getDataForLayout(): array
    {
        $latestPastes = $this->pasteRepository->getLatestPastes();
        $latestUserPastes = null;
        if(Auth::check()){
            $latestUserPastes = $this->pasteRepository->getLatestUserPastes(Auth::user()->id);
        }

        return compact('latestPastes', 'latestUserPastes');
    }
}
