

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Лига Чемпионов') | Лучшие клубы Европы</title>
    
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/ru/thumb/0/0a/UEFA_Champions_League_logo.svg/1920px-UEFA_Champions_League_logo.svg.png">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <div class="page">
        
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('clubs.index') }}">
                    <img src="https://upload.wikimedia.org/wikipedia/ru/thumb/0/0a/UEFA_Champions_League_logo.svg/1920px-UEFA_Champions_League_logo.svg.png" 
                         alt="Logo" class="img-fluid">
                    <span class="brand-text">Победители Лиги Чемпионов</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clubs.index') }}">
                                <i class="fas fa-futbol me-1"></i>Клубы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                                <i class="fas fa-users me-1"></i>Пользователи
                            </a>
                        </li>
                        
                        @auth
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link text-danger" href="{{ route('clubs.trashed') }}">
                                        <i class="fas fa-trash me-1"></i>Корзина
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    
                    <div class="d-flex align-items-center gap-2">
                        @auth
                            <a href="{{ route('clubs.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>Добавить клуб
                            </a>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i>
                                    {{ auth()->user()->name }}
                                    @if(auth()->user()->isAdmin())
                                        <span class="badge bg-danger">Admin</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                            <i class="fas fa-id-card me-2"></i>Мой профиль
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Выйти
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Войти</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Регистрация</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="container">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
                
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="site-footer">
            <div class="container">
                <div class="footer-content">
                    <p>Работу выполнил: Василевич Никита Алексеевич</p>
                    <div class="social">
                        <a href="https://t.me/AlshfjWnnaLhfve" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/83/Telegram_2019_Logo.svg/1280px-Telegram_2019_Logo.svg.png" alt="Telegram"></a>
                        <a href="https://ya.ru" target="_blank"><img src="https://avatars.mds.yandex.net/i?id=5725b347f97679106c5f8ed73a4c4d6f97219359-5498962-images-thumbs&n=13" alt="Yandex"></a>
                        <a href="https://www.utmn.ru" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/8/80/UTMN_logo_rus_wiki.png" alt="UTMN"></a>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>