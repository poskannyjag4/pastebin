<?php

namespace App\Http\Controllers;

use App\DTOs\PasteStoreDTO;
use App\Http\Requests\PasteStoreRequest;
use App\Models\Paste;
use App\Repositories\PasteRepository;
use App\Services\PasteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PasteController extends Controller
{
    public function __construct(
        private readonly PasteService $pasteService,
    ) {}

    /**
     * Показывает форму добавления пасты
     */
    public function index(): View
    {
        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];

        if (Auth::check()) {
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }
        return view('pastes.index', [
            'latestPastes' => $latestPastes,
            'latestUserPastes' => $latestUserPastes,
        ]);
    }

    /**
     * Сохраняет пасту в бд
     */
    public function store(PasteStoreRequest $request): RedirectResponse
    {
        $pasteDto = PasteStoreDTO::from($request->validated());
        try {
            $identifier = $this->pasteService->store($pasteDto, Auth::user());
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withInput()->withErrors(['expires_at' => 'Выбрано недопустимое время истечения. Пожалуйста, выберите значение из списка.']);
        }

        if (Str::isUuid($identifier)) {
            return redirect()->route('paste.share', ['uuid' => $identifier]);
        }

        return redirect()->route('paste.show', ['hashId' => $identifier]);
    }

    /**
     * Показывает пасту
     */
    public function show(string $hashId): View
    {
        $paste = $this->pasteService->get($hashId);
        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];

        if (Auth::check()) {
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }

        return view('pastes.show', [
            'latestPastes' => $latestPastes,
            'latestUserPastes' => $latestUserPastes,
            'paste' => $paste,
            'identifier' => $hashId,
        ]);
    }

    /**
     * Показывает пасту по секретной ссылке
     */
    public function share(string $uuid): View
    {
        $paste = $this->pasteService->getUnlisted($uuid);
        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];

        if (Auth::check()) {
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }

        return view('pastes.show', [
            'latestPastes' => $latestPastes,
            'latestUserPastes' => $latestUserPastes,
            'paste' => $paste,
            'identifier' => $uuid,
        ]);
    }

    /**
     * Показывает список паст пользователя с пагинацией
     */
    public function showUserPastes(): View
    {
        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];

        if (Auth::check()) {
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }
        $userPastes = $this->pasteService->getUserPastes(Auth::id());

        return view('pastes.user-pastes', [
            'latestPastes' => $latestPastes,
            'latestUserPastes'=>$latestUserPastes,
            'pastes'=>$userPastes,
        ]);
    }
}
