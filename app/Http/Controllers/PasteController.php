<?php

namespace App\Http\Controllers;

use App\DTOs\PasteDTO;
use App\Http\Requests\PasteStoreRequest;
use App\Services\PasteService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    /**
     * @param PasteService $pasteService
     */
    public function __construct(
        private PasteService $pasteService
    ){}

    /**
     *
     *
     * @return Factory|View|\Illuminate\View\View
     */
    public function index(): Factory|View|\Illuminate\View\View{
        $latestPastes = $this->pasteService->getDataForLayout();
        info('xuy');
        return view('pastes.index', $latestPastes);
    }

    /**
     * @param PasteStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PasteStoreRequest $request): RedirectResponse{
        $validated = $request->toDTO();
        try {
            $hashId = $this->pasteService->store($validated);
        }
        catch (\InvalidArgumentException $e){
            return redirect()->back()->withInput()->withErrors(['expires_at' => 'Выбрано недопустимое время истечения. Пожалуйста, выберите значение из списка.']);
        }
        return redirect()->route('paste.show', ['hashId' => $hashId]);
    }

    /**
     * @param string $hashId
     * @return View
     */
    public function show(string $hashId): View
    {
        $paste = $this->pasteService->get($hashId);
        $pastes = $this->pasteService->getDataForLayout();
        $pastes['paste'] = $paste;
        return view('pastes.show', $pastes);
    }
}
