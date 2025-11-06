<?php

namespace App\Orchid\Screens;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class UserListScreen extends Screen
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array<string, mixed>
     */
    public function query(): iterable
    {
        return [
            'users' => $this->userService->getUsers(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Список пользователей';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
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
            Layout::table('users', [
                TD::make('id', 'ID'),
                TD::make('name', 'Имя'),
                TD::make('email', 'Почта'),
                TD::make('is_banned', 'Бан'),
                TD::make()->render(fn (User $user) => Button::make('Забанить пользователя')
                    ->method('banUser')
                    ->parameters(['userId' => $user->id])),
            ]),
        ];
    }

    /**
     * @throws \Throwable
     */
    public function banUser(int $userId): void
    {
        try {
            $this->userService->ban($userId);
            Toast::success('Пользователь забанен!');
        } catch (ModelNotFoundException $ex) {
            Toast::error('Пользователь не найден!');
        } catch (\Exception $ex) {
            Toast::error($ex->getMessage());
        }
    }
}
