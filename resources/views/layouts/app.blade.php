<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'Laravel') }}</title>

      <!-- Police Poppins -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

      <!-- Scripts -->
      @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="font-sans antialiased bg-background text-text">
      <div class="min-h-screen flex flex-col">
          {{-- Barre de navigation --}}
          @include('layouts.navigation')

          {{-- En-tête de page --}}
          @isset($header)
              <header class="bg-white shadow-soft">
                  <div class="max-w-7xl mx-auto py-6 px-6">
                      {{ $header }}
                  </div>
              </header>
          @endisset

          {{-- Contenu principal --}}
          <main class="flex-1 py-10 px-4 sm:px-6 lg:px-8">
              {{ $slot }}
          </main>

          {{-- Pied de page --}}
          <footer class="bg-white shadow-inner py-4 text-center text-sm text-gray-500">
              © {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés
          </footer>
      </div>
  </body>
</html>
