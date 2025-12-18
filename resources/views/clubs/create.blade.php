{{-- resources/views/clubs/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Добавить клуб')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('clubs.index') }}"><i class="fas fa-home"></i> Каталог</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <img src="" alt=""> Добавить клуб
            </li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Добавить новый клуб
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @include('clubs._form')
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clubs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Отмена
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Добавить клуб
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection