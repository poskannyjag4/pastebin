<?php

namespace App\Http\Controllers;

use App\Services\PasteService;
use Illuminate\Http\Request;

class PasteController extends Controller
{
    /**
     * @param PasteService $pasteService
     */
    public function __construct(
        private PasteService $pasteService
    )
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View{

        $latestPastes = $this->pasteService->getDataForLayout();
        return view('pastes.index', $latestPastes);
    }
}
