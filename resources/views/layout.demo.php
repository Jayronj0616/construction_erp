<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Construction ERP - Demo')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Demo Notice Banner -->
    <div class="bg-yellow-500 text-yellow-900 px-4 py-2 text-center text-sm font-medium">
        🎯 DEMO MODE - This is a read-only demonstration. All forms and actions are disabled.
    </div>

    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">🏗️ Construction ERP</a>
                    
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">Dashboard</a>
                        <a href="{{ route('projects.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('projects.*') ? 'bg-blue-50 text-blue-600' : '' }}">Projects</a>
                        <a href="{{ route('materials.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('materials.*') || request()->routeIs('material-categories.*') || request()->routeIs('suppliers.*') ? 'bg-blue-50 text-blue-600' : '' }}">Materials</a>
                        <a href="{{ route('material-requests.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('material-requests.*') ? 'bg-blue-50 text-blue-600' : '' }}">Requests</a>
                        <a href="{{ route('workers.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded {{ request()->routeIs('workers.*') || request()->routeIs('worker-positions.*') || request()->routeIs('worker-categories.*') ? 'bg-blue-50 text-blue-600' : '' }}">Workers</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 text-sm font-medium">Demo User</span>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Disable all form submissions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Disable all forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('This is a demo version. Forms are disabled.');
                    return false;
                });
            });

            // Disable all buttons that might trigger actions
            const buttons = document.querySelectorAll('button[type="submit"], input[type="submit"]');
            buttons.forEach(button => {
                button.style.cursor = 'not-allowed';
                button.style.opacity = '0.6';
            });
        });
    </script>
</body>
</html>
