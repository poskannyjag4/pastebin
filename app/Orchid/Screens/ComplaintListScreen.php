<?php

namespace App\Orchid\Screens;

use App\Services\ComplaintService;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ComplaintListScreen extends Screen
{
    /**
     * @param ComplaintService $complaintService
     */
    public function __construct(
        private readonly ComplaintService $complaintService
    )
    {
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array<string, mixed>
     */
    public function query(): iterable
    {
        return [
            'complaints' => $this->complaintService->getComplaints()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'ComplaintListScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('xx', [
                TD::make('id', 'ID'),
                TD::make('details', 'Описание'),
                TD::make('user.name', 'Пользователь'),
                TD::make('paste.title', 'Паста'),


            ])
        ];

    }
}
