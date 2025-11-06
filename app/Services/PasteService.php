<?php

namespace App\Services;

use App\DTOs\LatestPastesDTO;
use App\DTOs\PasteStoreDTO;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use App\Models\User;
use Hashids\Hashids;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PasteService
{
    public function __construct(
        private readonly Hashids $hashids
    ) {}

    /**
     * Возвращает список из 10 последних публичных паст
     */
    public function getLatestPastes(): LatestPastesDTO
    {
        $latestPastes = Paste::getLatestPublic()->get()->mapWithKeys(
            function (Paste $paste) {
                return [$this->hashids->encode($paste->id) => $paste];
            }
        );

        return LatestPastesDTO::fromArray($latestPastes);
    }

    /**
     * Возвращает список из 10 последних паст пользователя
     */
    public function getLatestUserPastes(User $user): LatestPastesDTO
    {
        $latestUserPastes = Paste::getLatestUser($user->id)->get()->mapWithKeys(
            function (Paste $paste) {
                return [$this->hashids->encode($paste->id) => $paste];
            }
        );

        return LatestPastesDTO::fromArray($latestUserPastes);
    }

    /**
     * Создает новую пасту и создает для нее hashid
     */
    public function store(PasteStoreDTO $data, ?User $user): string
    {
        $dataForPaste = [
            'title' => $data->title,
            'text' => $data->text,
            'visibility' => $data->visibility,
            'expires_at' => $data->expires_at == 0 ? null : Carbon::now()->
            addSeconds($data->expires_at),
            'programming_language' => $data->programming_language,
            'token' => $data->visibility == VisibilityEnum::unlisted->name ? Str::uuid() : null,
        ];

        if (is_null($user)) {
            $paste = Paste::create($dataForPaste);
        } else {
            $paste = $user->pastes()->create($dataForPaste);
        }

        if (! is_null($paste->token)) {
            return $paste->token;
        }

        return $this->hashids->encode($paste->id);
    }

    /**
     * Возвращает пасту по hashid и проверяет доступность пасты
     */
    public function get(string $hashId): Paste
    {
        $id = $this->hashids->decode($hashId)[0];
        $paste = Paste::findOrFail($id);

        if (! is_null($paste->expires_at) && ($paste->expires_at < Carbon::now())) {
            abort(410, 'Срок действия этой страницы закончился!');
        }

        if ($paste->visibility != VisibilityEnum::public->name) {
            if (\Gate::denies('ViewPrivatePaste', $paste)) {
                abort(403, 'У вас нет прав на просмотр этой страницы!');
            }
        }

        return $paste;
    }

    public function getUnlisted(string $uuid): Paste
    {
        $paste = Paste::getByToken($uuid)->first();

        if (is_null($paste->expires_at) || $paste->expires_at > Carbon::now() || is_null($paste)) {
            return $paste;
        }

        abort(410, 'Срок действия этой страницы закончился!');
    }

    /**
     * @return array{
     *     pastes: Paginator<int, Paste>,
     *     hashIds: string[]
     * }
     */
    public function getUserPastes(int $id): array
    {
        $pastes = Paste::getForUser($id)->simplePaginate();
        $hashIds = [];

        foreach ($pastes->items() as $paste) {
            $hashIds[] = $this->hashids->encode($paste->id);
        }

        return compact('pastes', 'hashIds');
    }

    /**
     * Возвращает пасту по неопределенному указателю
     */
    public function getByIdentifier(string $identifier): Paste
    {
        try {
            if (Str::isUuid($identifier)) {
                $paste = $this->getUnlisted($identifier);
            } else {
                $paste = $this->get($identifier);
            }
        } catch (ModelNotFoundException $e) {
            throw $e;
        }

        return $paste;
    }

    /**
     * @return LengthAwarePaginator<int, Paste>
     */
    public function getAllPastes(): LengthAwarePaginator
    {
        return Paste::with('user')->paginate(15);
    }

    public function delete(int $id): int
    {
        return Paste::destroy($id);
    }
}
