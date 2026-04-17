<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel') — Secretaria de Saúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --azul:       #1a6fc4;
            --azul-dark:  #1a3f7a;
            --sidebar-w:  260px;
        }

        body { background: #f0f4f8; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--azul-dark), var(--azul));
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: transform 0.3s;
        }
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            display: block;
        }
        .sidebar-brand img { width: 40px; }
        .sidebar-brand span {
            font-weight: 700;
            font-size: 0.95rem;
            display: block;
            line-height: 1.2;
        }
        .sidebar-brand small { opacity: 0.7; font-size: 0.75rem; }

        .sidebar-nav { padding: 1rem 0; }
        .nav-section {
            padding: 0.5rem 1rem 0.25rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.4);
        }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.65rem 1.5rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white;
            padding-left: 2rem;
        }
        .sidebar-nav .nav-link i { width: 18px; text-align: center; }

        /* Topbar */
        .topbar {
            margin-left: var(--sidebar-w);
            background: white;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* Conteúdo */
        .main-content {
            margin-left: var(--sidebar-w);
            padding: 2rem;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-card .icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        /* Tabelas */
        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        .table thead th {
            background: #f8fafc;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border: none;
            padding: 1rem;
        }
        .table tbody td { padding: 0.85rem 1rem; vertical-align: middle; }

        /* Badges */
        .badge-publicado { background: #dcfce7; color: #166534; }
        .badge-rascunho  { background: #fef3c7; color: #92400e; }

        /* Mobile */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .topbar, .main-content { margin-left: 0; }
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- SIDEBAR --}}
    <nav class="sidebar" id="sidebar">

        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand d-flex align-items-center gap-2">
            <i class="fas fa-shield-heart fa-2x text-white"></i>
            <div>
                <span>Secretaria de Saúde</span>
                <small>Guarapuava</small>
            </div>
        </a>

        <ul class="sidebar-nav list-unstyled">

            <li><span class="nav-section">Geral</span></li>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-gauge"></i> Dashboard
                </a>
            </li>

            <li><span class="nav-section">Conteúdo</span></li>

            @can('criar_noticia')
            <li>
                <a href="{{ route('admin.noticias.index') }}"
                   class="nav-link {{ request()->routeIs('admin.noticias.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> Notícias
                </a>
            </li>
            @endcan

            @can('gerenciar_categorias')
            <li>
                <a href="{{ route('admin.categorias.index') }}"
                   class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categorias
                </a>
            </li>
            @endcan

            <li><span class="nav-section">Administração</span></li>

            @can('gerenciar_usuarios')
            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Usuários
                </a>
            </li>
            @endcan

            @can('gerenciar_roles')
            <li>
                <a href="{{ route('admin.roles.index') }}"
                   class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i> Papéis
                </a>
            </li>
            @endcan

        </ul>

        {{-- Logout --}}
        <div class="p-3 border-top border-white border-opacity-10 mt-auto position-absolute bottom-0 w-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn w-100 text-white border-white border-opacity-25">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                </button>
            </form>
        </div>

    </nav>

    {{-- TOPBAR --}}
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm d-md-none" onclick="toggleSidebar()">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <h6 class="mb-0 fw-semibold text-secondary">@yield('page-title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary rounded-pill">
                <i class="fas fa-user me-1"></i>
                {{ auth()->user()->name }}
            </span>
            <span class="badge bg-secondary rounded-pill">
                {{ auth()->user()->getRoleNames()->first() }}
            </span>
        </div>
    </div>

    {{-- CONTEÚDO --}}
    <main class="main-content">

        {{-- Alertas --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    @yield('scripts')
</body>
</html>