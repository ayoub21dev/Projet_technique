<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard - ConnectHub')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        window.CONTACT_ROUTES = {
            index: "{{ route('contacts.index') }}",
            store: "{{ route('contacts.store') }}"
        };
    </script>
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
        
        .eco-header {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .eco-table th {
            color: #64748b;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .eco-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .eco-table tbody tr:hover {
            background-color: #fafbfc;
        }
        
        .eco-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .eco-badge-blue {
            background-color: #dbeafe;
            color: #1d4ed8;
        }
        
        .eco-badge-green {
            background-color: #dcfce7;
            color: #15803d;
        }
        
        .eco-badge-purple {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .eco-btn-primary {
            background-color: #2563eb;
            color: white;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .eco-btn-primary:hover {
            background-color: #1d4ed8;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }
        
        .eco-search-input {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            font-size: 0.875rem;
            width: 280px;
            transition: all 0.2s;
        }
        
        .eco-search-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background-color: white;
        }
        
        .eco-select {
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.625rem 2.5rem 0.625rem 1rem;
            font-size: 0.875rem;
            color: #64748b;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
        
        .eco-select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .eco-action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .eco-action-btn.edit {
            color: #2563eb;
        }
        
        .eco-action-btn.edit:hover {
            background-color: #dbeafe;
        }
        
        .eco-action-btn.delete {
            color: #dc2626;
        }
        
        .eco-action-btn.delete:hover {
            background-color: #fee2e2;
        }
        
        .eco-pagination {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .eco-pagination-btn {
            min-width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            color: #64748b;
            background-color: #f1f5f9;
        }
        
        .eco-pagination-btn:hover {
            background-color: #e2e8f0;
        }
        
        .eco-pagination-btn.active {
            background-color: #2563eb;
            color: white;
        }
        
        .price-text {
            font-weight: 600;
            color: #2563eb;
        }
    </style>
</head>
<body class="bg-slate-50/80 h-full antialiased text-gray-900">
    <!-- Top Header -->
    <header class="eco-header fixed top-0 inset-x-0 z-50 h-16 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">
                <!-- Left: Logo -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-slate-800">Connect<span class="text-blue-600">Hub</span></span>
                    </a>
                </div>
                
                <!-- Right: Menu & Language -->
                <div class="flex items-center gap-4">
                    <button type="button" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-white rounded-lg transition-colors lg:hidden" data-hs-overlay="#application-sidebar">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div class="hidden lg:flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                        <span>FR</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative group">
                        <div class="flex items-center gap-3 cursor-pointer py-1 px-2 rounded-lg hover:bg-slate-50 transition-colors">
                            <span class="hidden md:block text-sm font-semibold text-slate-700">{{ Auth::user()->name ?? 'User' }}</span>
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                        
                        <!-- Dropdown -->
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="px-4 py-2 border-b border-slate-100 mb-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Account</p>
                                <p class="text-sm font-medium text-slate-700 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 transition-colors font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar (Hidden on mobile) -->
    <div id="application-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-[64px] start-0 bottom-0 z-[60] w-64 bg-white border-r border-gray-100 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
        <nav class="px-4 w-full flex flex-col flex-wrap">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('contacts.index') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }} text-sm rounded-lg transition-all duration-200" href="{{ route('contacts.index') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>
                </li>
                
                <li class="pt-4 mt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-x-3.5 py-2.5 px-3 text-red-600 hover:bg-red-50 text-sm rounded-lg transition-all duration-200 font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>

    <!-- Content -->
    <div class="w-full pt-20 px-4 sm:px-6 md:px-8 lg:ps-72 min-h-screen">
        @if(session('success'))
            <div class="max-w-6xl mx-auto mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif

        <div class="max-w-6xl mx-auto">
            @yield('content')
        </div>
    </div>

    <!-- Preline & Alpine init -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.HSStaticMethods && window.HSStaticMethods.autoInit) {
                window.HSStaticMethods.autoInit();
            }
            if (window.Alpine) {
                window.Alpine.start();
            }
        });
    </script>
</body>
</html>
