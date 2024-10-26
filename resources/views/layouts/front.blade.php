<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title') | {{ $option->site_name }} </title>
    {{-- Meta Tag Seo --}}
    <meta name="robots" content="@yield('robots')"> {{-- index, follow --}}
    <meta name="description" content="@yield('meta_description')" /> {{-- 155 Karakter --}}
    <Meta Name="keywords" content="@yield('keywords')" />
    <meta property="og:title" content="@yield('meta_title')" /> {{-- 35 Karakter --}}
    <meta property="og:url" content="@yield('og_url')" />
    <meta property="og:description" content="@yield('short_description')" /> {{-- 65 Karakter --}}
    <meta property="og:image" content="@yield('img_url')" />
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="id_ID" />
    <link rel="canonical" href="@yield('canonical')" />

    <meta property="og:site_name" content="{{ $option->site_name }} | {{ $option->site_tagline }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@edikomputer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ $option->favicon_url }}">
    {!! $option->google_ads !!}
</head>

<body class="d-flex flex-column min-vh-100 bg-body-secondary">
    @include('sweetalert::alert')
    <div id="app">
        @include('layouts.inc.navbar')

        <main class="">
            @yield('content')
        </main>
    </div>
    @include('layouts.inc.footer')
</body>

@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    (() => {
        "use strict";
        const storedTheme = localStorage.getItem("theme");
        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme;
            }
            return window.matchMedia("(prefers-color-scheme: dark)").matches ?
                "dark" :
                "light";
        };
        const setTheme = function(theme) {
            if (
                theme === "auto" &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            ) {
                document.documentElement.setAttribute("data-bs-theme", "dark");
            } else {
                document.documentElement.setAttribute("data-bs-theme", theme);
            }
        };
        setTheme(getPreferredTheme());
        const showActiveTheme = (theme) => {
            const activeThemeIcon = document.querySelector(".theme-icon-active");
            const btnToActive = document.querySelector(
                `[data-bs-theme-value="${theme}"]`
            );
            const iconOfActiveBtn = btnToActive.querySelector("i").dataset.themeIcon;
            document.querySelectorAll("[data-bs-theme-value]").forEach((element) => {
                element.classList.remove("active");
            });
            btnToActive.classList.add("active");
            activeThemeIcon.classList.remove(activeThemeIcon.dataset.themeIconActive);
            activeThemeIcon.classList.add(iconOfActiveBtn);
            activeThemeIcon.dataset.iconActive = iconOfActiveBtn;
        };
        window
            .matchMedia("(prefers-color-scheme: dark)")
            .addEventListener("change", () => {
                if (storedTheme !== "light" || storedTheme !== "dark") {
                    setTheme(getPreferredTheme());
                }
            });
        window.addEventListener("DOMContentLoaded", () => {
            showActiveTheme(getPreferredTheme());
            document.querySelectorAll("[data-bs-theme-value]").forEach((toggle) => {
                toggle.addEventListener("click", () => {
                    const theme = toggle.getAttribute("data-bs-theme-value");
                    localStorage.setItem("theme", theme);
                    setTheme(theme);
                    showActiveTheme(theme, true);
                });
            });
        });
    })();
</script>
@yield('scripts')

</html>
