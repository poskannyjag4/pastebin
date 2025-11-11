<?php

namespace App\Services;

use App\DTOs\PasteDTO;
use App\DTOs\PasteStoreDTO;
use App\Enums\VisibilityEnum;
use App\Models\Paste;
use App\Models\User;
use App\Repositories\PasteRepository;
use Hashids\Hashids;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Prettus\Validator\Exceptions\ValidatorException;

class PasteService
{
    public function __construct(
        private readonly Hashids $hashids,
        private readonly PasteRepository $repository,
    ) {}

    /**
     * Возвращает список из 10 последних публичных паст
     *
     * @return Collection<int,PasteDTO>
     */
    public function getLatestPastes(): Collection
    {
        $latestPastes = $this->repository->getLatestPublic();

        return PasteDTO::collect($latestPastes->map(function ($paste) {
            return PasteDTO::from([
                'paste' => $paste,
                'identifier' => $this->hashids->encode($paste->id),
            ]);
        }));
    }

    /**
     * @return Collection<int,PasteDTO>
     */
    public function getLatestUserPastes(User $user): Collection
    {
        $latestUserPastes = $this->repository->getLatestUser($user->id);

        return PasteDTO::collect($latestUserPastes->map(function ($paste) {
            return PasteDTO::from([
                'paste' => $paste,
                'identifier' => $this->hashids->encode($paste->id),
            ]);
        }));
    }

    /**
     * @throws ValidatorException
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
            $paste = $this->repository->create($dataForPaste);
        } else {
            $dataForPaste['user_id'] = $user->id;
            $paste = $this->repository->create($dataForPaste);
        }

        if (! is_null($paste->token)) {
            return $paste->token;
        }

        return $this->hashids->encode($paste->id);
    }

    public function get(string $hashId): PasteDTO
    {
        $id = $this->hashids->decode($hashId)[0];
        $paste = $this->repository->find($id);

        if (! is_null($paste->expires_at) && ($paste->expires_at < Carbon::now())) {
            abort(410, 'Срок действия этой страницы закончился!');
        }

        if ($paste->visibility != VisibilityEnum::public->name) {
            if (\Gate::denies('ViewPrivatePaste', $paste)) {
                abort(403, 'У вас нет прав на просмотр этой страницы!');
            }
        }

        return PasteDTO::from([
            'paste' => $paste,
            'identifier' => $this->hashids->encode($paste->id),
        ]);
    }

    public function getUnlisted(string $uuid): PasteDTO
    {
        $paste = $this->repository->findByField('token', $uuid)->first();
        if (is_null($paste->expires_at) || $paste->expires_at > Carbon::now() || is_null($paste)) {
            return PasteDTO::from([
                'paste' => $paste,
                'identifier' => $this->hashids->encode($paste->id),
            ]);
        }

        abort(410, 'Срок действия этой страницы закончился!');
    }

    /**
     * @return Paginator<int,PasteDTO>
     */
    public function getUserPastes(int $id): Paginator
    {
        $pastes = $this->repository->findByField('user_id', $id);
        $data = PasteDTO::collect($pastes->map(function ($paste) {
            return PasteDTO::from([
                'paste' => $paste,
                'identifier' => $this->hashids->encode($paste->id),
            ]);
        }));

        return new Paginator($data, 10);
    }

    /**
     * Возвращает пасту по неопределенному указателю
     */
    public function getByIdentifier(string $identifier): PasteDTO
    {
        if (Str::isUuid($identifier)) {
            $paste = $this->getUnlisted($identifier);
        } else {
            $paste = $this->get($identifier);
        }

        return $paste;
    }

    /**
     * @return LengthAwarePaginator<int, Paste>
     */
    public function getAllPastes(): LengthAwarePaginator
    {
        return $this->repository->getPaginatedWithUser();
    }

    public function delete(int $id): int
    {
        return $this->repository->delete($id);
    }
}
