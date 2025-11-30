<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @if (session('success'))
        <meta name="success-message" content="{{ session('success') }}">
    @endif
    
    @if (session('error'))
        <meta name="error-message" content="{{ session('error') }}">
    @endif
    
    @if ($errors->any())
        <meta name="validation-errors" content='@json($errors->all())'>
    @endif
    
    <title>@yield('title', 'Construction ERP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">🏗️ Construction ERP</a>
                    
                    @auth
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">Dashboard</a>
                        <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('projects.*') ? 'bg-blue-50 text-blue-600' : '' }}">Projects</a>
                        <a href="{{ route('materials.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('materials.*') || request()->routeIs('material-categories.*') || request()->routeIs('suppliers.*') ? 'bg-blue-50 text-blue-600' : '' }}">Materials</a>
                        <a href="{{ route('material-requests.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('material-requests.*') ? 'bg-blue-50 text-blue-600' : '' }}">Requests</a>
                        <a href="{{ route('workers.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('workers.*') || request()->routeIs('worker-positions.*') || request()->routeIs('worker-categories.*') ? 'bg-blue-50 text-blue-600' : '' }}">Workers</a>
                    </div>
                    @endauth
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-700 text-sm">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600 font-medium">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>
</body>
</html>
