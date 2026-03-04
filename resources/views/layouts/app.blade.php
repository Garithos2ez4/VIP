<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="VIP2CARS – Sistema de gestión de vehículos y clientes premium">
    <title>@yield('title', 'VIP2CARS') – Panel de Gestión</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0f172a;        /* Slate 900 */
            --surface: #1e293b;        /* Slate 800 */
            --card:    #334155;        /* Slate 700 */
            --accent:  #3b82f6;        /* Blue 500 */
            --accent2: #60a5fa;        /* Blue 400 */
            --border:  rgba(255, 255, 255, 0.1);
            --text-muted: rgba(255, 255, 255, 0.55);
        }

        * { font-family: 'Inter', sans-serif; }

        body {
            background: var(--primary);
            color: #e8e8e8;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary) 0%, var(--surface) 100%);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 1.5rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: 0.04em;
            color: var(--accent) !important;
        }
        .navbar-brand span { color: #fff; }
        .nav-link { color: rgba(255,255,255,0.75) !important; transition: color .2s; }
        .nav-link:hover { color: var(--accent) !important; }
        .nav-link.active { color: var(--accent2) !important; font-weight: 600; }

        /* ── Page wrapper ── */
        .page-wrapper {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.25rem;
        }

        /* ── Cards / panels ── */
        .card-dark {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.4);
        }
        .card-dark .card-header {
            background: linear-gradient(90deg, rgba(59,130,246,0.12) 0%, transparent 100%);
            border-bottom: 1px solid var(--border);
            border-radius: 12px 12px 0 0;
            padding: 1rem 1.5rem;
        }

        /* ── Buttons ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
            color: #ffffff;
            font-weight: 600;
            border: none;
            transition: filter .2s, transform .15s;
        }
        .btn-primary-custom:hover { filter: brightness(1.12); transform: translateY(-1px); color: #ffffff; }
        .btn-outline-primary-custom {
            border: 1px solid var(--accent);
            color: var(--accent);
            background: transparent;
            transition: all .2s;
        }
        .btn-outline-primary-custom:hover { background: var(--accent); color: #ffffff; }

        /* ── Table ── */
        .table-dark-custom {
            color: #e8e8e8;
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(255,255,255,0.02);
            --bs-table-hover-bg: rgba(59,130,246,0.06);
            border-color: rgba(255,255,255,0.08);
        }
        .table-dark-custom thead th {
            background: rgba(59,130,246,0.15);
            color: var(--accent2);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid var(--border);
        }

        /* ── Forms ── */
        .form-control-dark, .form-select-dark {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: #e8e8e8;
            border-radius: 8px;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control-dark:focus, .form-select-dark:focus {
            background: rgba(255,255,255,0.08);
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.25);
        }
        .form-control-dark::placeholder { color: rgba(255,255,255,0.3); }
        .form-label { font-size: 0.85rem; font-weight: 500; color: rgba(255,255,255,0.75); margin-bottom: 0.3rem; }

        /* ── Badges ── */
        .badge-placa { background: rgba(59,130,246,0.15); color: var(--accent2); border: 1px solid var(--accent); border-radius: 6px; font-family: monospace; letter-spacing: 0.08em; }

        /* ── Alerts ── */
        .alert-success-custom { background: rgba(25,135,84,0.15); border: 1px solid rgba(25,135,84,0.4); color: #75e0a7; border-radius: 8px; }
        .alert-danger-custom  { background: rgba(220,53,69,0.15);  border: 1px solid rgba(220,53,69,0.4);  color: #ff8a9b; border-radius: 8px; }

        /* ── Pagination ── */
        .page-item .page-link { background: var(--card); border-color: var(--border); color: #ccc; }
        .page-item.active .page-link { background: var(--accent); border-color: var(--accent); color: #fff; }
        .page-item .page-link:hover { background: rgba(59,130,246,0.2); color: var(--accent2); }

        /* ── Animation ── */
        .fade-in { animation: fadeIn .35s ease forwards; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>

<!-- ───── Navbar ───── -->
<nav class="navbar navbar-expand-md navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('vehicles.index') }}">
            🏎 VIP2<span>CARS</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}"
                       href="{{ route('vehicles.index') }}">
                        <i class="bi bi-car-front-fill me-1"></i> Vehículos
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                @auth
                    <span class="text-muted small">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-outline-primary-custom btn-sm" type="submit">
                            <i class="bi bi-box-arrow-right me-1"></i>Salir
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- ───── Flash Messages ───── -->
<div class="page-wrapper pb-0 mb-0">
    @if(session('success'))
        <div class="alert alert-success-custom alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{!! session('success') !!}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger-custom alert-dismissible fade show mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- ───── Main Content ───── -->
<main class="page-wrapper fade-in">
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
