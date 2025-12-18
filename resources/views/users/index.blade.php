@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
    <h1 class="page-title"><i class="fas fa-users me-2"></i>Пользователи</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($users as $user)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-4x text-secondary"></i>
                        </div>
                        <h5 class="card-title">
                            {{ $user->name }}
                            @if($user->is_admin)
                                <span class="badge bg-danger">Admin</span>
                            @endif
                        </h5>
                        <p class="text-muted">{{ $user->email }}</p>
                        <p class="card-text">
                            <span class="badge bg-primary">
                                <i class="fas fa-futbol me-1"></i>{{ $user->clubs_count }} клубов
                            </span>
                        </p>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary">
                            Смотреть профиль
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection