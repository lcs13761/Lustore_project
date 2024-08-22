<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body class="bg-gray-100">
<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Loja de Roupas</h1>
        <nav class="text-end">
            <ul class="hidden md:flex space-x-4 justify-end">
                <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800" wire:navigate>Início</a></li>
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Produtos</a></li>
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Categorias</a></li>
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Carrinho</a></li>
                <li><a href="{{ route('about') }}" class="text-gray-600 hover:text-gray-800" wire:navigate>Sobre</a></li>
                <li><a href="#" class="text-gray-600 hover:text-gray-800">Contato</a></li>
            </ul>
            <div class="md:hidden">
                <button id="menu-toggle" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </div>
    <div id="mobile-menu" class="hidden md:hidden">
        <ul class="flex flex-col space-y-4">
            <li><a href="#" class="text-gray-600 hover:text-gray-800">Início</a></li>
            <li><a href="#" class="text-gray-600 hover:text-gray-800">Produtos</a></li>
            <li><a href="#" class="text-gray-600 hover:text-gray-800">Categorias</a></li>
            <li><a href="#" class="text-gray-600 hover:text-gray-800">Carrinho</a></li>
            <li><a href="#" class="text-gray-600 hover:text-gray-800">Sobre</a></li>
            <li><a href="#" class="text-gray-600 hover:text-gray-800">Contato</a></li>
        </ul>
    </div>
</header>

<main>
    {{ $slot }}
</main>

<footer class="bg-white shadow py-6">
    <div class="container mx-auto px-4 text-center">
        <p class="text-gray-600">&copy; 2023 Loja de Roupas. Todos os direitos reservados.</p>
    </div>
</footer>

@vite(['resources/js/app.js'])
@stack('scripts')
</body>
</html>
