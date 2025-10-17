<?php

namespace App\Services;

use App\DTOs\CreatedPasteDTO;
use App\DTOs\LatestPastesDTO;
use App\DTOs\PasteDTO;
use App\DTOs\PasteForLatestDTO;
use App\DTOs\PasteStoreDTO;
use App\Enums\ExpirationEnum;
use App\Enums\LanguageEnum;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use App\Models\User;
use App\Repositories\PasteRepository;
use Hashids\Hashids;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Ramsey\Uuid\UuidInterface;

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
     *  latestPastes: Collection<string, Paste>,
     *  latestUserPastes: Collection<string, Paste>|null
     *  }
     */
    public function getDataForLayout(): array
    {

        $latestPastes = $this->pasteRepository->getLatestPastes()->mapWithKeys(
            function (Paste $paste) {
                return [$this->hashids->encode($paste->id) => $paste];
            }
        );
        $latestUserPastes = null;
        if(Auth::check()){
            $latestUserPastes = $this->pasteRepository->getLatestUserPastes(Auth::user()->id)->mapWithKeys(
                function (Paste $paste) {
                    return [$this->hashids->encode($paste->id) => $paste];
                }
            );;
        }

        return compact('latestPastes', 'latestUserPastes');
    }

    /**
     * Возвращает список из 10 последних публичных паст
     * 
     * @return LatestPastesDTO
     */
    public function getLatestPastes(): LatestPastesDTO{
        $latestPastes = $this->pasteRepository->getLatestPastes()->mapWithKeys(
            function (Paste $paste) {
                return [$this->hashids->encode($paste->id) => $paste];
            }
        );

        return LatestPastesDTO::fromArray($latestPastes);
    }

    /**
     * Возвращает список из 10 последних паст пользователя
     * 
     * @param int $id
     * @return LatestPastesDTO
     */
    public function getLatestUserPastes(int $id): LatestPastesDTO{
        $latestUserPastes = $this->pasteRepository->getLatestUserPastes($id)->mapWithKeys(
            function (Paste $paste) {
                return [$this->hashids->encode($paste->id) => $paste];
            }
        );;

        return LatestPastesDTO::fromArray($latestUserPastes);
    }

    /**
     * Создает новую пасту и создает для нее hashid
     *
     * @param PasteDTO $data
     * @return string
     */
    public function store(PasteStoreDTO $data, ?User $user): string
    {
        $dataForPaste = [
            'title' => $data->title,
            'text' => $data->text,
            'visibility' => $data->visibility,
            'expires_at' => $data->expires_at == 0 ?  null : Carbon::now()->
            addSeconds($data->expires_at),
            'programming_language' => $data->programming_language,
            'token' => $data->visibility == VisibilityEnum::unlisted->name ? Str::uuid() : null
        ];

 
        $paste = $this->pasteRepository->create($dataForPaste, $user);
        if(!is_null($paste->token)){
            return $paste->token;
        }
        return $this->hashids->encode($paste->id);

    }

    /**
     * Возвращает пасту по hashid и проверяет доступность пасты
     * @param string $hashId
     * @return Paste
     */
    public function get(string $hashId): Paste{
        /**
         * @var int $id
         */
        $id = $this->hashids->decode($hashId)[0];
        $paste = $this->pasteRepository->get($id);
        if(!is_null($paste->expires_at) && ($paste->expires_at < Carbon::now())){
            abort(404);
        }
        if($paste->visibility != VisibilityEnum::public->name ){
            if(\Gate::denies('ViewPrivatePaste', $paste)){
                abort(404);
            }
        }
        return $paste;
    }

    /**
     * @param string $uuid
     * @return Paste
     */
    public function getUnlisted(string $uuid): Paste{
        $paste = $this->pasteRepository->getByToken($uuid);
        if(is_null($paste->expires_at) || $paste->expires_at < Carbon::now() || is_null($paste)){
            return $paste;
        }
        abort(404);
    }

    /**
     * @return array{
     *     pastes: Paginator<int, Paste>,
     *     hashIds: string[]
     * }
     */
    public function getUserPastes(): array
    {
        if(!Auth::check()){
          abort(404);
        }
        $pastes = $this->pasteRepository->getUserPastes(Auth::id());
        $hashIds = [];
        foreach ($pastes->items() as $paste){
            $hashIds[] = $this->hashids->encode($paste->id);
        }
        return compact('pastes', 'hashIds');
    }

    /**
     * Возвращает пасту по неопределенному указателю
     * @param string $identifier
     * @return Paste
     */
    public function getByIdentifier(string $identifier): Paste
    {
        if(Str::isUuid($identifier)){
            $paste = $this->getUnlisted($identifier);
        }
        else{
            $paste = $this->get($identifier);
        }

        return $paste;
    }

    /**
     * @return LengthAwarePaginator<int, Paste>
     */
    public function getAllPastes(): LengthAwarePaginator
    {
        return $this->pasteRepository->getAllPastes();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id){
        return $this->pasteRepository->delete($id);
    }
}
