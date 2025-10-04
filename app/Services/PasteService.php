<?php

namespace App\Services;

use App\DTOs\CreatedPasteDTO;
use App\DTOs\PasteDTO;
use App\Enums\ExpirationEnum;
use App\Models\Paste;
use App\Repositories\PasteRepository;
use Hashids\Hashids;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class PasteService
{
    /**
     * @param PasteRepository $pasteRepository
     * @param Hashids $hashids
     */
    public function __construct(
        private readonly PasteRepository $pasteRepository,
        private readonly Hashids $hashids
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

    /**
     * Создает новую пасту и создает для нее hashid
     *
     *
     * @param PasteDTO $data
     * @return string
     */
    public function store(PasteDTO $data): string
    {
        $expires_at = ExpirationEnum::hoursFromName($data->expires_at);

        /**
         * @var Paste $paste
         */
        $paste = $this->pasteRepository->create([
            'title' => $data->title,
            'text' => $data->text,
            'visibility' => $data->visibility,
            'expires_at' => $expires_at == 0 ?  null : Carbon::now()->
            addHours($expires_at),
            'programming_language' => $data->programming_language
        ]);

        return $this->hashids->encode($paste->id);

    }

    public function get(string $hashId): Paste{
        /**
         * @var int $id
         */
        $id = $this->hashids->decode($hashId)[0];
        return $this->pasteRepository->get($id);
    }
}
