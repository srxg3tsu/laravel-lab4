@extends('layouts.app')

@section('title', 'Корзина — Удалённые клубы')

@section('content')
    <h1 class="page-title"><i class="fas fa-trash-alt me-2"></i>Корзина</h1>
    <p class="text-center text-muted mb-4">Удалённые клубы (Soft Deletes)</p>

    @if($clubs->isEmpty())
        <div class="alert alert-info text-center">
            <h4>Корзина пуста</h4>
            <p>Нет удалённых клубов.</p>
            <a href="{{ route('clubs.index') }}" class="btn btn-primary">Вернуться к каталогу</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Лига</th>
                        <th>Автор</th>
                        <th>Удалён</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clubs as $club)
                        <tr>
                            <td>{{ $club->id }}</td>
                            <td>
                                <img src="{{ $club->image_url }}" alt="" style="height: 30px; width: auto;" class="me-2">
                                {{ $club->name }}
                            </td>
                            <td>{{ $club->league }}</td>
                            <td>{{ $club->user->name ?? 'Неизвестно' }}</td>
                            <td>{{ $club->deleted_at->format('d.m.Y H:i') }}</td>
                            <td>
                                {{-- Восстановить --}}
                                <form action="{{ route('clubs.restore', $club->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Восстановить">
                                        <i class="fas fa-undo"></i> Восстановить
                                    </button>
                                </form>
                                
                                {{-- Полностью удалить --}}
                                <form action="{{ route('clubs.force-delete', $club->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить навсегда" onclick="return confirm('Удалить клуб НАВСЕГДА? Это действие необратимо!')">
                                        <i class="fas fa-times"></i> Удалить навсегда
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection