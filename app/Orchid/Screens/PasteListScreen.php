<?php

namespace App\Orchid\Screens;

use App\Models\Paste;
use App\Services\PasteService;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PasteListScreen extends Screen
{
    /**
     * @param PasteService $pasteService
     */
    public function __construct(
        private readonly PasteService $pasteService
    ){}

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array<string, mixed>
     */
    public function query(): iterable {
        return [
            'pastes' => $this->pasteService->getAllPastes()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string {
        return 'PasteListScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable {
        return [
            Layout::table('pastes', [
                TD::make('id', 'ID'),
                TD::make('title', 'Название'),
                TD::make('programming_language', 'Синтаксис'),
                TD::make('visibility', 'Уровень доступа'),
                TD::make('expires_at', 'Срок годности'),
                TD::make('user.name', 'Пользователь'),
                TD::make()->render(fn(Paste $paste) =>
                Button::make('Удалить')
                    ->method('DeletePaste')
                    ->parameters(['id' => $paste->id])
                )
            ])
        ];
    }

    /**
     * @param int $id
     * @return void
     */
    public function DeletePaste(int $id): void {
        try{
            if($this->pasteService->delete($id) == 0){
                Toast::warning('Паста не была удалена, попробуйте снова!');
            }
            else{
                Toast::success('Паста удалена!');
            }
        }
        catch(\Exception $ex)
        {
            Toast::error('Произошла ошибка!');
        }
    }
}
