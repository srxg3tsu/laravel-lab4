{{-- resources/views/clubs/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Редактировать: ' . $club->name)

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('clubs.index') }}"><i class="fas fa-home"></i> Каталог</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('clubs.show', $club) }}">{{ $club->name }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Редактирование</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Редактировать клуб
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('clubs.update', $club) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        @include('clubs._form')
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clubs.show', $club) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Отмена
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection