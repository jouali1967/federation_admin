<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration</title>
      <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/bootstrap-icons.min.css') }}"/>
      <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />
      <link href="{{ asset('dist/css/select2.min.css') }}" rel="stylesheet" />


      @livewireStyles
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @can('view_dashboard')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    @endcan
                    @can('manage_users')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">Utilisateurs</a>
                    </li>
                    @endcan
                    @can('manage_roles')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.roles') }}">Rôles</a>
                    </li>
                    @endcan
                </ul>
                <!-- Liens à droite -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home.page') }}">Retour au site</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="display: inline; padding: var(--bs-nav-link-padding-y) var(--bs-nav-link-padding-x);">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Administration</h1>
        {{ $slot }}
    </div>
      <script src="{{ asset('dist/js/jquery.js') }}"></script>

  <script src="{{ asset('dist/js/select2.min.js') }}"></script>

  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    @livewireScripts
</body>
</html>
