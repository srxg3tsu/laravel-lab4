<?php
// app/Http/Controllers/ClubController.php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    /**
     * Отображение списка всех клубов
     * GET /clubs
     */
    public function index()
    {
        $clubs = Club::latest()->get();
        
        return view('clubs.index', compact('clubs'));
    }

     public function __construct()
    {
        // Требуем авторизацию для всех действий кроме index и show
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Форма создания нового клуба
     * GET /clubs/create
     */
    public function create()
    {
        return view('clubs.create');
    }
    //Список клубов конкретного пользователя
    public function userClubs(User $user)
    {
        // Для админа показываем включая удалённые
        if (auth()->check() && auth()->user()->isAdmin()) {
            $clubs = $user->allClubs()->latest()->get();
        } else {
            $clubs = $user->clubs()->latest()->get();
        }

        return view('clubs.user-clubs', compact('user', 'clubs'));
    }


    /**
     * Сохранение нового клуба
     * POST /clubs
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'league' => 'required|string|max:255',
            'short_description' => 'required|string|min:10',
            'full_description' => 'nullable|string',
            'stadium' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'titles' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ]);

        // user_id присваивается автоматически через событие модели
        
        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->uploadImage($request->file('image'));
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->image_url;
        }

        Club::create($validated);

        return redirect()
            ->route('clubs.index')
            ->with('success', 'Клуб успешно добавлен!');
    }

    /**
     * Отображение детальной страницы клуба
     * GET /clubs/{club}
     */
    public function show(Club $club)
    {
        return view('clubs.show', compact('club'));
    }

    /**
     * Форма редактирования клуба
     * GET /clubs/{club}/edit
     */
    public function edit(Club $club)
    {
        return view('clubs.edit', compact('club'));
    }

    /**
     * Обновление клуба
     * PUT /clubs/{club}
     */
    public function update(Request $request, Club $club)
    {
        if (Gate::denies('update-club', $club)) {
            abort(403, 'У вас нет прав для редактирования этого клуба');
        }
        // Валидация
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'league' => 'required|string|max:255',
            'short_description' => 'required|string|min:10',
            'full_description' => 'nullable|string',
            'stadium' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'titles' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url',
        ], [
            'name.required' => 'Название клуба обязательно для заполнения',
            'name.min' => 'Название должно содержать минимум 2 символа',
            'league.required' => 'Укажите лигу/страну',
            'short_description.required' => 'Краткое описание обязательно',
            'short_description.min' => 'Краткое описание должно содержать минимум 10 символов',
        ]);

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение (если оно локальное)
            $this->deleteOldImage($club);
            $validated['image_path'] = $this->uploadImage($request->file('image'));
        } elseif ($request->filled('image_url')) {
            $this->deleteOldImage($club);
            $validated['image_path'] = $request->image_url;
        }

        // Обновление клуба
        $club->update($validated);

        return redirect()
            ->route('clubs.show', $club)
            ->with('success', 'Клуб "' . $club->name . '" успешно обновлён!');
    }
    // восстановление удалённого клуба
    public function restore($id)
    {
        $club = Club::withTrashed()->findOrFail($id);
        if (Gate::denies('restore-club', $club)) {
            abort(403, 'Только администратор может восстанавливать клубы');
        }

        $club->restore();

        return redirect()
            ->back()
            ->with('success', 'Клуб "' . $club->name . '" восстановлен!');
    }
    // Полное удаление клуба
    public function forceDelete($id)
    {
        $club = Club::withTrashed()->findOrFail($id);
        if (Gate::denies('force-delete-club', $club)) {
            abort(403, 'Только администратор может полностью удалять клубы');
        }

        // Удаляем изображение
        $this->deleteOldImage($club);
        
        $clubName = $club->name;
        $club->forceDelete(); // Полное удаление

        return redirect()
            ->back()
            ->with('success', 'Клуб "' . $clubName . '" полностью удалён!');
    }
    //показат удалённые клубы
    public function trashed()
    {
        if (Gate::denies('admin')) {
            abort(403, 'Доступ только для администратора');
        }

        $clubs = Club::onlyTrashed()->with('user')->latest()->get();

        return view('clubs.trashed', compact('clubs'));
    }

    /**
     * Удаление клуба (Soft Delete)
     * DELETE /clubs/{club}
     */
    public function destroy(Club $club)
    {
        $clubName = $club->name;
        
        // Soft delete - клуб не удаляется физически
        $club->delete();

        return redirect()
            ->route('clubs.index')
            ->with('success', 'Клуб "' . $clubName . '" успешно удалён!');
    }

    /**
     * Загрузка и обработка изображения
     */
    private function uploadImage($image): string
    {
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image->getClientOriginalName());
        $path = $image->storeAs('clubs', $filename, 'public');
        
        return $path;
    }

    /**
     * Удаление старого изображения
     */
    private function deleteOldImage(Club $club): void
    {
        if ($club->image_path && !filter_var($club->image_path, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($club->image_path);
        }
    }
}