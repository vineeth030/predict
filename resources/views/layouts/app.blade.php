
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BEO Predict</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  </head>
  <body class="app-body">

    <div class="app-shell">
      <header class="app-header navbar navbar-expand-lg">
        <div class="container-fluid align-items-center">
          <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('games') }}">
            <span class="brand-mark">B</span>
            <div>
              <div class="brand-title">BEO Predict</div>
              <small class="brand-subtitle">Control Center</small>
            </div>
          </a>
          <div class="d-flex align-items-center gap-2 ms-auto">
            <button class="btn btn-icon d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
              <i class="bi bi-list"></i>
            </button>
          </div>
        </div>
      </header>

      <div class="container-fluid app-layout">
        <div class="row flex-nowrap">
          <aside class="app-sidebar col-12 col-md-3 col-lg-2 p-0">
            <div class="offcanvas-md offcanvas-start h-100" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
              <div class="offcanvas-body d-flex flex-column pt-4">
                <div class="sidebar-heading">Navigation</div>
                <nav class="nav flex-column sidebar-nav">
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('games') ? 'active' : '' }}" aria-current="{{ request()->routeIs('games') ? 'page' : '' }}" href="{{ route('games') }}">
                    <i class="bi bi-controller"></i>
                    Games
                  </a>
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('teams.index') ? 'active' : '' }}" aria-current="{{ request()->routeIs('teams.index') ? 'page' : '' }}" href="{{ route('teams.index') }}">
                    <i class="bi bi-people"></i>
                    Teams
                  </a>
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('versions') ? 'active' : '' }}" aria-current="{{ request()->routeIs('versions') ? 'page' : '' }}" href="{{ route('versions') }}">
                    <i class="bi bi-layers"></i>
                    Versions
                  </a>
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('edit') ? 'active' : '' }}" aria-current="{{ request()->routeIs('edit') ? 'page' : '' }}" href="{{ route('edit') }}">
                    <i class="bi bi-pencil-square"></i>
                    Edit Games
                  </a>
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('domain') ? 'active' : '' }}" aria-current="{{ request()->routeIs('domain') ? 'page' : '' }}" href="{{ route('domain') }}">
                    <i class="bi bi-globe"></i>
                    Manage Domain
                  </a>
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('users') ? 'active' : '' }}" aria-current="{{ request()->routeIs('users') ? 'page' : '' }}" href="{{ route('users') }}">
                    <i class="bi bi-person-badge"></i>
                    View Users
                  </a>
                  <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('feedback') ? 'active' : '' }}" aria-current="{{ request()->routeIs('feedback') ? 'page' : '' }}" href="{{ route('feedback') }}">
                    <i class="bi bi-chat-dots"></i>
                    Feedback
                  </a>
                </nav>
                <div class="sidebar-signout">
                  <a class="nav-link d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}">
                    <i class="bi bi-door-closed"></i>
                    Sign out
                  </a>
                </div>
              </div>
            </div>
          </aside>

          @yield('content')

        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
