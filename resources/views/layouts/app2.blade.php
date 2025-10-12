<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title', 'BCFC')</title>
    @include('layouts.head')
    @yield('css')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('layouts.header')

        <main class="app-main">
            <div class="app-content">
                @yield('content')
            </div>
        </main>
    </div>
    @include('layouts.footer')
	@include('layouts.alertMessage')
    @yield('js')
</body>

</html>
