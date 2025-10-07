<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComplaintRequest;
use App\Services\ComplaintService;
use App\Services\PasteService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    /**
     * @param ComplaintService $complaintService
     * @param PasteService $pasteService
     */
    public function __construct(
        private readonly ComplaintService $complaintService,
        private readonly PasteService $pasteService
    )
    {
    }

    /**
     * @param string $identifier
     * @return View
     */
    function show(string $identifier): View
    {
        $paste = $this->pasteService->getByIdentifier($identifier);
        return View('complaints.show', compact('paste', 'identifier'));
    }

    /**
     * @param ComplaintRequest $request
     * @param string $identifier
     * @return RedirectResponse
     */
    function store(ComplaintRequest $request, string $identifier): RedirectResponse
    {
        if($this->complaintService->store($request->toDTO(), $identifier)){
            return redirect()->route('paste.home');
        }
        $route = 'complaint.showHashId';
        if(Str::isUuid($identifier)){
            $route = 'complaint.showUuid';
        }
        return redirect()->route($route, $identifier)->withErrors(['details' => 'Произошла ошибка! Повторите позже.']);
    }
}
