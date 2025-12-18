@extends('layouts.app')

@section('title', 'Профиль: ' . $user->name)

@section('content')
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="card">
                <div class="card-body">
                    <i class="fas fa-user-circle fa-5x text-secondary mb-3"></i>
                    <h3>
                        {{ $user->name }}
                        @if($user->is_admin)
                            <span class="badge bg-danger">Admin</span>
                        @endif
                    </h3>
                    <p class="text-muted">{{ $user->email }}</p>
                    @if($user->username)
                        <p class="text-muted">@{{ $user->username }}</p>
                    @endif
                    <p>
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-futbol me-1"></i>{{ $clubs->count() }} клубов
                        </span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <h4 class="mb-4">
                <i class="fas fa-futbol me-2"></i>Клубы пользователя
            </h4>
            
            @if($clubs->isEmpty())
                <div class="alert alert-info">
                    <p class="mb-0">У пользователя пока нет добавленных клубов.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Клуб</th>
                                <th>Лига</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clubs as $club)
                                <tr class="{{ $club->trashed() ? 'table-danger' : '' }}">
                                    <td>
                                        <img src="{{ $club->image_url }}" alt="" style="height: 30px;" class="me-2">
                                        {{ $club->name }}
                                    </td>
                                    <td>{{ $club->league }}</td>
                                    <td>
                                        @if($club->trashed())
                                            <span class="badge bg-danger">Удалён</span>
                                        @else
                                            <span class="badge bg-success">Активен</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($club->trashed())
                                            @can('restore-club', $club)
                                                <form action="{{ route('clubs.restore', $club->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @else
                                            <a href="{{ route('clubs.show', $club) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection