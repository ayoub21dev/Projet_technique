@extends('layouts.guest')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden before:absolute before:top-0 before:start-1/2 before:bg-[url('https://preline.co/assets/svg/examples/polygon-bg-element.svg')] before:bg-no-repeat before:bg-top before:bg-cover before:w-full before:h-full before:-z-[1] before:transform before:-translate-x-1/2">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
    <!-- Title -->
    <div class="mt-5 max-w-2xl text-center mx-auto">
      <h1 class="block font-bold text-gray-800 text-4xl md:text-5xl lg:text-6xl dark:text-gray-200">
        Connect <span class="bg-clip-text bg-gradient-to-tl from-blue-600 to-violet-600 text-transparent">Better</span>
      </h1>
    </div>
    <!-- End Title -->

    <div class="mt-5 max-w-3xl text-center mx-auto">
      <p class="text-lg text-gray-600 dark:text-gray-400">Manage your professional relationships with ease. Explore our network of contacts and connect with modern tools.</p>
    </div>

    <!-- Search Section -->
    <div class="mt-10 max-w-2xl mx-auto">
        <form action="{{ route('home') }}" method="GET">
            <div class="relative flex rounded-xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/20">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                    class="py-4 ps-11 pe-24 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600 outline-none transition-all border shadow-sm"
                    placeholder="Search by name, email or city...">
                <div class="absolute inset-y-0 end-0 flex items-center pe-1.5">
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="inline-flex justify-center items-center h-[2.5rem] w-[2.5rem] text-sm font-semibold rounded-lg border border-transparent text-gray-400 hover:text-gray-600 transition-colors focus:outline-none focus:text-gray-600 disabled:opacity-50 disabled:pointer-events-none dark:text-gray-500 dark:hover:text-gray-400 dark:focus:text-gray-400">
                            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </a>
                    @endif
                    <button type="submit" class="inline-flex justify-center items-center h-[2.875rem] w-[5rem] px-4 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all shadow-md shadow-blue-200/50">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- End Search Section -->
  </div>
</div>
<!-- End Hero -->

<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Grid -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($contacts as $contact)
    <!-- Card -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-2xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7] transition-all hover:shadow-xl hover:-translate-y-1">
      <div class="h-52 flex flex-col justify-center items-center bg-blue-50 rounded-t-2xl dark:bg-slate-800 overflow-hidden relative">
        @if($contact->photo)
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $contact->photo) }}" alt="{{ $contact->prenom }}">
        @else
            <div class="flex items-center justify-center bg-blue-100 text-blue-600 w-full h-full">
                <span class="text-4xl font-bold tracking-tighter opacity-70">{{ strtoupper(substr($contact->prenom, 0, 1)) }}{{ strtoupper(substr($contact->nom, 0, 1)) }}</span>
            </div>
        @endif
        
        <!-- Badge Cities -->
        <div class="absolute top-3 end-3 flex flex-wrap gap-1 justify-end max-w-[70%]">
            @foreach($contact->cities as $city)
                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-lg text-xs font-semibold bg-white/90 text-gray-800 shadow-sm backdrop-blur-md">
                    {{ $city->nom }}
                </span>
            @endforeach
        </div>
      </div>
      <div class="p-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-blue-600 transition-colors">
          {{ $contact->prenom }} {{ $contact->nom }}
        </h3>
        <p class="mt-2 text-gray-600 dark:text-gray-500 text-sm flex items-center gap-2">
            <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            {{ $contact->email }}
        </p>
        <p class="mt-1 text-gray-600 dark:text-gray-500 text-sm flex items-center gap-2">
            <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            {{ $contact->telephone }}
        </p>
      </div>
      <div class="mt-auto flex border-t border-gray-200 dark:border-gray-700 divide-x divide-gray-200 dark:divide-gray-700">
        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-es-2xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 transition-colors" href="mailto:{{ $contact->email }}">
          Email
        </a>
        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-ee-2xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 transition-colors" href="tel:{{ $contact->telephone }}">
          Call
        </a>
      </div>
    </div>
    <!-- End Card -->
    @empty
    <div class="col-span-full py-20 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
        <div class="relative inline-flex items-center justify-center p-4 bg-gray-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800">No contacts found</h3>
        <p class="text-gray-600 mt-2">Try adjusting your search criteria or clear the filters.</p>
        <a href="{{ route('home') }}" class="mt-4 inline-flex items-center gap-x-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800">
            Clear all filters
            <svg class="shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </a>
    </div>
    @endforelse
  </div>
  <!-- End Grid -->

  <!-- Pagination -->
  <div class="mt-12 flex justify-center">
    {{ $contacts->appends(request()->query())->links() }}
  </div>
</div>
@endsection
