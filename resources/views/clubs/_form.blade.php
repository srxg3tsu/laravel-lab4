{{-- resources/views/clubs/_form.blade.php --}}

<div class="row">
    <!-- Название клуба -->
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">
            Название клуба <span class="text-danger">*</span>
        </label>
        <input type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               id="name" 
               name="name" 
               value="{{ old('name', $club->name ?? '') }}"
               required
               minlength="2"
               maxlength="255"
               placeholder="Например: Реал Мадрид">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Лига/Страна -->
    <div class="col-md-6 mb-3">
        <label for="league" class="form-label">
            Лига / Страна <span class="text-danger">*</span>
        </label>
        <input type="text" 
               class="form-control @error('league') is-invalid @enderror" 
               id="league" 
               name="league" 
               value="{{ old('league', $club->league ?? '') }}"
               required
               maxlength="255"
               placeholder="Например: Испания — ЛаЛига">
        @error('league')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Краткое описание -->
<div class="mb-3">
    <label for="short_description" class="form-label">
        Краткое описание <span class="text-danger">*</span>
    </label>
    <textarea class="form-control @error('short_description') is-invalid @enderror" 
              id="short_description" 
              name="short_description" 
              rows="3"
              required
              minlength="10"
              placeholder="Краткая информация о клубе (отображается в карточке)">{{ old('short_description', $club->short_description ?? '') }}</textarea>
    @error('short_description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Полное описание -->
<div class="mb-3">
    <label for="full_description" class="form-label">
        Полное описание
    </label>
    <textarea class="form-control @error('full_description') is-invalid @enderror" 
              id="full_description" 
              name="full_description" 
              rows="5"
              placeholder="Подробная информация о клубе (отображается на детальной странице)">{{ old('full_description', $club->full_description ?? '') }}</textarea>
    @error('full_description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <!-- Стадион -->
    <div class="col-md-6 mb-3">
        <label for="stadium" class="form-label">Стадион</label>
        <input type="text" 
               class="form-control @error('stadium') is-invalid @enderror" 
               id="stadium" 
               name="stadium" 
               value="{{ old('stadium', $club->stadium ?? '') }}"
               maxlength="255"
               placeholder="Например: Сантьяго Бернабеу">
        @error('stadium')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Год основания -->
    <div class="col-md-6 mb-3">
        <label for="founded_year" class="form-label">Год основания</label>
        <input type="number" 
               class="form-control @error('founded_year') is-invalid @enderror" 
               id="founded_year" 
               name="founded_year" 
               value="{{ old('founded_year', $club->founded_year ?? '') }}"
               min="1800"
               max="{{ date('Y') }}"
               placeholder="Например: 1902">
        @error('founded_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Достижения -->
<div class="mb-3">
    <label for="titles" class="form-label">Достижения / Титулы</label>
    <textarea class="form-control @error('titles') is-invalid @enderror" 
              id="titles" 
              name="titles" 
              rows="2"
              placeholder="Например: 35 чемпионств Испании, 14 Лиг чемпионов">{{ old('titles', $club->titles ?? '') }}</textarea>
    @error('titles')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Изображение -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="image" class="form-label">Загрузить логотип</label>
        <input type="file" 
               class="form-control @error('image') is-invalid @enderror" 
               id="image" 
               name="image"
               accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml">
        <small class="text-muted">Форматы: JPEG, PNG, GIF, SVG. Максимум 2MB</small>
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label for="image_url" class="form-label">Или укажите URL изображения</label>
        <input type="url" 
               class="form-control @error('image_url') is-invalid @enderror" 
               id="image_url" 
               name="image_url" 
               value="{{ old('image_url') }}"
               placeholder="https://example.com/logo.png">
        @error('image_url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@if(isset($club) && $club->image_path)
    <div class="mb-3">
        <label class="form-label">Текущий логотип</label>
        <div>
            <img src="{{ $club->image_url }}" 
                 alt="{{ $club->name }}" 
                 style="max-height: 100px; max-width: 200px;"
                 class="img-thumbnail">
        </div>
    </div>
@endif