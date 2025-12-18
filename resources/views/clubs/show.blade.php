{{-- resources/views/clubs/show.blade.php --}}

@extends('layouts.app')

@section('title', $club->name)

@section('content')
    <div class="club-detail">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('clubs.index') }}"><i class="fas fa-home"></i> Каталог</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $club->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Логотип клуба -->
            <div class="col-md-4 text-center mb-4">
                <img src="{{ $club->image_url }}" 
                     class="club-logo img-fluid rounded shadow" 
                     alt="{{ $club->name }}">
                     
                @if($club->club_age)
                    <p class="mt-3 text-muted">
                        <i class="fas fa-birthday-cake me-2"></i>
                        Возраст клуба: <strong>{{ $club->club_age }} лет</strong>
                    </p>
                @endif
            </div>
            
            <!-- Информация о клубе -->
            <div class="col-md-8">
                <h1 class="mb-3">{{ $club->name }}</h1>
                <h5 class="text-muted mb-4">
                    <i class="fas fa-trophy me-2"></i>{{ $club->league }}
                </h5>
                
                <hr>
                
                <div class="info-section">
                    <h5><i class="fas fa-align-left me-2"></i>Описание</h5>
                    <p>{{ $club->full_description ?? $club->short_description }}</p>
                </div>
                
                @if($club->stadium)
                    <div class="info-section">
                        <h5><i class="fas fa-landmark me-2"></i>Стадион</h5>
                        <p>{{ $club->stadium }}</p>
                    </div>
                @endif
                
                @if($club->founded_year)
                    <div class="info-section">
                        <h5><i class="fas fa-calendar-alt me-2"></i>Год основания</h5>
                        <p>{{ $club->founded_year }}</p>
                    </div>
                @endif
                
                @if($club->titles)
                    <div class="info-section">
                        <h5><i class="fas fa-medal me-2"></i>Достижения</h5>
                        <p>{{ $club->titles }}</p>
                    </div>
                @endif
                
                <hr>
                
                <!-- Кнопки действий -->
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('clubs.edit', $club) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Редактировать
                    </a>
                    
                    <form action="{{ route('clubs.destroy', $club) }}" method="POST" class="d-inline" id="delete-form-show">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('delete-form-show')">
                            <i class="fas fa-trash me-2"></i>Удалить
                        </button>
                    </form>
                    
                    <a href="{{ route('clubs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Назад к каталогу
                    </a>
                </div>
                
                <small class="text-muted d-block mt-4">
                    <i class="fas fa-clock me-1"></i>
                    Добавлено: {{ $club->formatted_created_at }}
                    @if($club->updated_at->ne($club->created_at))
                        | Обновлено: {{ $club->formatted_updated_at }}
                    @endif
                </small>
            </div>
        </div>
    </div>
@endsection