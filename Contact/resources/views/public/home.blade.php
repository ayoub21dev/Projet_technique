@extends('layouts.guest')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Hero Section -->
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-4">
            Manage your contacts <br/>
            <span class="text-blue-600">simpler & cleaner.</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
            The modern way to organize your professional network. Beautiful profiles, smart filtering, and effortless management.
        </p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto">
            <form action="{{ route('home') }}" method="GET" class="relative group">
                <div class="relative flex items-center bg-white rounded-2xl shadow-sm border border-gray-200 group-hover:border-gray-300 transition-all focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent p-1.5">
                    <div class="pl-4 pr-3 text-gray-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        class="flex-1 py-3 bg-transparent border-none focus:ring-0 text-gray-900 placeholder-gray-400 text-sm md:text-base outline-none" 
                        placeholder="Search by name, email or city...">
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="px-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                    <button type="submit" class="ml-2 px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-sm shadow-blue-200 active:scale-95">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-8 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Contacts Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($contacts as $contact)
            <div class="group bg-white rounded-3xl border border-gray-100 p-6 transition-all duration-300 hover:shadow-xl hover:shadow-gray-200/50 hover:-translate-y-1">
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-4">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gray-50 border border-gray-100 group-hover:border-blue-100 transition-colors flex items-center justify-center relative">
                            @if($contact->photo)
                                <img src="{{ asset('storage/' . $contact->photo) }}" 
                                     alt="{{ $contact->prenom }}" 
                                     class="w-full h-full object-cover z-10"
                                     onerror="this.classList.add('hidden'); this.parentElement.querySelector('.placeholder-fallback').classList.remove('hidden');">
                            @endif
                            
                            <div class="placeholder-fallback {{ $contact->photo ? 'hidden' : '' }} w-full h-full flex items-center justify-center bg-blue-50 text-blue-600">
                                <span class="text-2xl font-bold tracking-tighter">{{ strtoupper(substr($contact->prenom, 0, 1)) }}{{ strtoupper(substr($contact->nom, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                        {{ $contact->prenom }} {{ $contact->nom }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $contact->email }}</p>
                    
                    <div class="flex flex-wrap justify-center gap-2 mb-6">
                        @foreach($contact->cities as $city)
                            <span class="px-3 py-1 bg-gray-50 text-gray-600 text-xs font-medium rounded-full border border-gray-100">
                                {{ $city->nom }}
                            </span>
                        @endforeach
                    </div>
                    
                    <a href="mailto:{{ $contact->email }}" class="w-full py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Contact via Email
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-50 rounded-2xl mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-gray-500 font-medium">No contacts found.</p>
                <a href="{{ route('home') }}" class="text-blue-600 text-sm font-semibold hover:underline mt-2 inline-block">Clear filters</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $contacts->appends(request()->query())->links() }}
    </div>
</div>
@endsection
