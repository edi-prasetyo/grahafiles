<nav class="navbar navbar-expand-lg navbar-light shadow-sm border-bottom" aria-label="Offcanvas navbar large">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if ($option->logo_url == null)
                {{ $option->site_name }}
            @else
                <img class="navbar-logo" src="{{ $option->logo_url }}">
            @endif
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2"
            aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-body-emphasis" tabindex="-1" id="offcanvasNavbar2"
            aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header bg-body-tertiary">
                <h5 class="offcanvas-title text-body-emphasis" id="offcanvasNavbar2Label"><img class="navbar-logo"
                        src="{{ $option->logo_url }}"></h5>
                <button type="button" class="btn-close link-body-emphasis" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-grow-1">
                    <form class="input-group mt-3  me-3 mt-lg-0" role="search" style="width: 100%"
                        action="{{ url('search') }}" method="GET">
                        @csrf
                        <input type="text" name="keyword" class="form-control" placeholder="Cari File"
                            aria-label="Search Question" aria-describedby="button-addon2" value="{{ old('keyword') }}">
                        <button class="btn btn-secondary" type="submit" id="button-addon2"><i class="ti ti-search"></i>
                            Cari</button>
                    </form>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="ti ti-login-2"></i>
                                    Login</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"><i class="ti ti-user-filled"></i>
                                    {{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                    <li class='nav-item dropdown'>
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class='bi theme-icon-active' data-theme-icon-active='bi-sun-fill'></i>
                        </a>
                        <ul class='dropdown-menu dropdown-menu-end'>
                            <li>
                                <button class='dropdown-item d-flex align-items-center' data-bs-theme-value='light'
                                    type='button'>
                                    <i class='bi bi-sun-fill me-2 opacity-50' data-theme-icon='bi-sun-fill'></i>
                                    Light
                                </button>
                            </li>
                            <li>
                                <button class='dropdown-item d-flex align-items-center' data-bs-theme-value='dark'
                                    type='button'>
                                    <i class='bi bi-moon-fill me-2 opacity-50' data-theme-icon='bi-moon-fill'></i>
                                    Dark
                                </button>
                            </li>
                            <li>
                                <button class='dropdown-item d-flex align-items-center' data-bs-theme-value='auto'
                                    type='button'>
                                    <i class='bi bi-circle-half me-2 opacity-50' data-theme-icon='bi-circle-half'></i>
                                    Auto
                                </button>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>

@guest
@else
    <div class="nav-scroller bg-body-tertiary border-bottom border-top">
        <div class="container">
            <nav class="nav text-center" aria-label="Secondary navigation">
                @role('superadmin|writer|admin|demo')
                    <a class="nav-link link-body-emphasis text-decoration-none" aria-current="page"
                        href="{{ url('home') }}">
                        <i class="ti ti-home"></i> Dashboard</a>
                @endrole
                @role('superadmin|demo')
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('options') }}"><i
                            class="ti ti-settings text-secondary"></i> Options</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('roles') }}"> <i
                            class="ti ti-password-user text-secondary"></i> Roles</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('users') }}"><i
                            class="ti ti-users text-secondary"></i> Users</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('pages') }}"> <i
                            class="ti ti-file-description text-secondary"></i> Pages</a>
                @endrole
                @role('superadmin|admin|demo')
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('tags') }}"><i
                            class="ti ti-tags text-secondary"></i> Tags</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('users') }}"><i
                            class="ti ti-users text-secondary"></i> Users</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('categories') }}"> <i
                            class="ti ti-category text-secondary"></i> Category</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('banners') }}"> <i
                            class="ti ti-category text-secondary"></i> Banner</a>
                @endrole
                @role('superadmin|admin|writer|demo')
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('file-manager') }}"><i
                            class="ti ti-news text-secondary"></i> File Manager</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('posts') }}"><i
                            class="ti ti-news text-secondary"></i> Post</a>
                    <a class="nav-link link-body-emphasis text-decoration-none" href="{{ url('profile') }}"> <i
                            class="ti ti-user-edit text-secondary"></i> Profile</a>
                @endrole
            </nav>
        </div>
    </div>
@endguest
