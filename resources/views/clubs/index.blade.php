{{-- resources/views/clubs/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Каталог клубов')

@section('content')
    <h1 class="page-title">Лабораторная работа №3</h1>

    @if($clubs->isEmpty())
        <div class="alert alert-info text-center">
            <h4><i class="fas fa-futbol me-2"></i>Клубы не найдены</h4>
            <p class="mb-3">Добавьте первый футбольный клуб в каталог!</p>
            <a href="{{ route('clubs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Добавить клуб
            </a>
        </div>
    @else
        <div class="row cards-grid row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @foreach($clubs as $club)
                <div class="col">
                    <div class="card h-100" data-club-id="{{ $club->id }}">
                        <div class="card-img-wrapper">
                            <img src="{{ $club->image_url }}" 
                                 class="card-img-top img-fluid" 
                                 alt="{{ $club->name }}">
                            <span class="badge bg-primary">{{ $club->league }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $club->name }}</h5>
                            <p class="card-text flex-grow-1">{{ $club->limited_description }}</p>
                            
                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary flex-grow-1">
                                    Подробнее
                                </a>
                                <a href="{{ route('clubs.edit', $club) }}" class="btn btn-outline-warning" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('clubs.destroy', $club) }}" method="POST" class="d-inline" id="delete-form-{{ $club->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger" title="Удалить" onclick="confirmDelete('delete-form-{{ $club->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection