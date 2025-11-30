@extends('layout')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Welcome to Construction ERP</h1>
        <p class="text-gray-600 mt-1">Manage your construction projects, materials, and workforce</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Projects Card -->
        <a href="{{ route('projects.index') }}" class="block p-6 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-blue-900">Projects</h4>
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <p class="text-blue-700 text-sm">Manage construction projects</p>
        </a>

        <!-- Materials Card -->
        <a href="{{ route('materials.index') }}" class="block p-6 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-green-900">Materials</h4>
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <p class="text-green-700 text-sm">Track materials inventory</p>
        </a>

        <!-- Material Requests Card -->
        <a href="{{ route('material-requests.index') }}" class="block p-6 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-yellow-900">Material Requests</h4>
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <p class="text-yellow-700 text-sm">Handle material requests</p>
        </a>

        <!-- Workers Card -->
        <a href="{{ route('workers.index') }}" class="block p-6 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-purple-900">Workers</h4>
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-purple-700 text-sm">Manage workforce</p>
        </a>

        <!-- Suppliers Card -->
        <a href="{{ route('suppliers.index') }}" class="block p-6 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-red-900">Suppliers</h4>
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <p class="text-red-700 text-sm">Manage suppliers</p>
        </a>

        <!-- Material Categories Card -->
        <a href="{{ route('material-categories.index') }}" class="block p-6 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition">
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-semibold text-indigo-900">Categories</h4>
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <p class="text-indigo-700 text-sm">Material categories</p>
        </a>
    </div>
</div>
@endsection
