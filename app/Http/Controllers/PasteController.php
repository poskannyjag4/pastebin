<?php

namespace App\Http\Controllers;

use App\DTOs\PasteDTO;
use App\DTOs\PasteStoreDTO;
use App\Http\Requests\PasteStoreRequest;
use App\Services\PasteService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PasteController extends Controller
{
    /**
     * @param PasteService $pasteService
     */
    public function __construct(
        private readonly PasteService $pasteService
    ){}


    /**
     * Показывает форму добавления пасты
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function index(): Factory|View|\Illuminate\View\View{

        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];
        if(Auth::check()){
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }
        return view('pastes.index', compact('latestPastes', 'latestUserPastes'));
    }

    /**
     * Сохраняет пасту в бд
     *
     * @param PasteStoreDTO $request
     * @return RedirectResponse
     */
    public function store(PasteStoreDTO $request): RedirectResponse{
        try {
            $identifier = $this->pasteService->store($request, Auth::user());
        }
        catch (\InvalidArgumentException $e){
            return redirect()->back()->withInput()->withErrors(['expires_at' => 'Выбрано недопустимое время истечения. Пожалуйста, выберите значение из списка.']);
        }

        if(Str::isUuid($identifier)){
            return redirect()->route('paste.share', ['uuid' => $identifier]);
        }
        return redirect()->route('paste.show', ['hashId' => $identifier]);
    }

    /**
     * Показывает пасту
     *
     * @param string $hashId
     * @return View
     */
    public function show(string $hashId): View
    {

        $paste = $this->pasteService->get($hashId);

        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];
        if(Auth::check()){
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }

        $pastes['latestPastes'] = $latestPastes;
        $pastes['latestUserPastes'] = $latestUserPastes;
        $pastes['paste'] = $paste;
        $pastes['identifier'] = $hashId;
        return view('pastes.show', $pastes);
    }

    /**
     * Показывает пасту по секретной ссылке
     *
     * @param string $uuid
     * @return View
     */

    public function share(string $uuid): View{

        $paste = $this->pasteService->getUnlisted($uuid);

        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];
        if(Auth::check()){
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }

        $pastes['latestPastes'] = $latestPastes;
        $pastes['latestUserPastes'] = $latestUserPastes;
        $pastes['paste'] = $paste;
        $pastes['identifier'] = $uuid;

        return view('pastes.show', $pastes);
    }

    /**
     * Показывает список паст пользователя с пагинацией
     *
     * @return View
     */
    public function showUserPastes(): View
    {

        $latestPastes = $this->pasteService->getLatestPastes();
        $latestUserPastes = [];
        if(Auth::check()){
            $latestUserPastes = $this->pasteService->getLatestUserPastes(Auth::user());
        }
        $pastes['latestPastes'] = $latestPastes;
        $pastes['latestUserPastes'] = $latestUserPastes;
        $userPastes = $this->pasteService->getUserPastes(Auth::id());
        return view('pastes.user-pastes', [...$userPastes, ...$pastes]);
    }
}
