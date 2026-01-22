<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ConnectHub - Smart Contact Management')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50/50 h-full font-sans antialiased text-gray-900">
    <!-- ========== HEADER ========== -->
    <header class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-100">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16" aria-label="Global">
            <div class="flex items-center">
                <a class="flex items-center gap-2 text-xl font-bold tracking-tight text-gray-900" href="{{ route('home') }}">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span>Connect<span class="text-blue-600">Hub</span></span>
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <a class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors" href="{{ route('home') }}">Home</a>
                <a class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition-all shadow-sm shadow-blue-200" href="{{ url('/admin') }}">
                    Dashboard
                </a>
            </div>
        </nav>
    </header>
    <!-- ========== END HEADER ========== -->

    <main id="content" role="main" class="min-h-[calc(100vh-140px)]">
        @yield('content')
    </main>

    <!-- ========== FOOTER ========== -->
    <footer class="w-full bg-white border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-lg font-bold text-gray-900">
                    <span class="text-blue-600">Connect</span>Hub
                </div>
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} ConnectHub. Built for modern professionals.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors"><i class="fab fa-github"></i></a>
                    <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <!-- ========== END FOOTER ========== -->
</body>
</html>
