<?php
// app/Http/Controllers/ClubController.php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
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

    /**
     * Форма создания нового клуба
     * GET /clubs/create
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Сохранение нового клуба
     * POST /clubs
     */
    public function store(Request $request)
    {
        // Валидация на стороне сервера
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
            // Кастомные сообщения об ошибках
            'name.required' => 'Название клуба обязательно для заполнения',
            'name.min' => 'Название должно содержать минимум 2 символа',
            'league.required' => 'Укажите лигу/страну',
            'short_description.required' => 'Краткое описание обязательно',
            'short_description.min' => 'Краткое описание должно содержать минимум 10 символов',
            'founded_year.min' => 'Год основания не может быть раньше 1800',
            'founded_year.max' => 'Год основания не может быть в будущем',
            'image.image' => 'Файл должен быть изображением',
            'image.max' => 'Размер изображения не должен превышать 2MB',
        ]);

        // Обработка изображения
        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->uploadImage($request->file('image'));
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->image_url;
        }

        // Создание клуба
        Club::create($validated);

        return redirect()
            ->route('clubs.index')
            ->with('success', 'Клуб "' . $validated['name'] . '" успешно добавлен!');
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