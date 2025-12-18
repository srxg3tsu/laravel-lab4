@extends('layouts.app')

@section('title', 'Каталог клубов')

@section('content')
    <h1 class="page-title">Лабораторная работа №4</h1>

    @if($clubs->isEmpty())
        <div class="alert alert-info text-center">
            <h4><i class="fas fa-futbol me-2"></i>Клубы не найдены</h4>
            <p>Добавьте первый футбольный клуб в каталог!</p>
            @auth
                <a href="{{ route('clubs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Добавить клуб
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Войдите, чтобы добавить клуб</a>
            @endauth
        </div>
    @else
        <div class="row cards-grid row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @foreach($clubs as $club)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-img-wrapper">
                            <img src="{{ $club->image_url }}" class="card-img-top img-fluid" alt="{{ $club->name }}">
                            <span class="badge bg-primary">{{ $club->league }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $club->name }}</h5>
                            
                            {{-- Автор клуба --}}
                            @if($club->user)
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-user me-1"></i>
                                    <a href="{{ route('users.show', $club->user) }}">{{ $club->user->name }}</a>
                                </p>
                            @endif
                            
                            <p class="card-text flex-grow-1">{{ $club->limited_description }}</p>
                            
                            <div class="d-flex gap-2 mt-auto flex-wrap">
                                <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary btn-sm flex-grow-1">
                                    Подробнее
                                </a>
                                
                                {{-- Кнопки только если есть права (проверка на уровне интерфейса) --}}
                                @can('update-club', $club)
                                    <a href="{{ route('clubs.edit', $club) }}" class="btn btn-outline-warning btn-sm" title="Редактировать">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                
                                @can('delete-club', $club)
                                    <form action="{{ route('clubs.destroy', $club) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Удалить" onclick="return confirm('Удалить клуб?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection