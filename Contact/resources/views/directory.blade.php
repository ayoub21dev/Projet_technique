@extends('layouts.guest')

@section('title', 'Contact Directory - ConnectHub')

@section('content')
<!-- Directory Header -->
<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-8">
  <div class="text-center">
    <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
      Contact Directory
    </h1>
    <p class="mt-4 text-lg text-gray-600">
      Browse our professional network directory
    </p>
  </div>

  <!-- Search Form -->
  <div class="mt-8 max-w-md mx-auto">
    <form method="GET" action="{{ route('public.directory') }}">
      <div class="relative">
        <input 
          type="text" 
          name="search" 
          value="{{ request('search') }}"
          placeholder="Search contacts..." 
          class="w-full px-4 py-3 pl-10 pr-4 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >
        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
          <span class="sr-only">Search</span>
          <svg class="w-5 h-5 text-blue-600 hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"></path>
          </svg>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Contacts Grid -->
<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pb-12">
  @if(request('search'))
    <div class="mb-6">
      <p class="text-sm text-gray-600">
        Showing results for "<span class="font-medium">{{ request('search') }}</span>"
        <a href="{{ route('public.directory') }}" class="ml-2 text-blue-600 hover:text-blue-700">Clear search</a>
      </p>
    </div>
  @endif

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($contacts as $contact)
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition-shadow duration-200">
      <div class="h-48 flex flex-col justify-center items-center bg-gradient-to-br from-blue-500 to-blue-600 rounded-t-xl overflow-hidden">
        @if($contact->photo)
          <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out" src="{{ asset('storage/' . $contact->photo) }}" alt="{{ $contact->prenom }} {{ $contact->nom }}">
        @else
          <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
            </svg>
          </div>
        @endif
      </div>
      
      <div class="p-4 flex-1 flex flex-col">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">
          {{ $contact->prenom }} {{ $contact->nom }}
        </h3>
        
        <p class="text-sm text-gray-600 mb-3 flex-1">
          {{ $contact->email }}
        </p>
        
        @if($contact->cities->count() > 0)
          <div class="flex flex-wrap gap-1">
            @foreach($contact->cities->take(2) as $city)
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $city->nom }}
              </span>
            @endforeach
            @if($contact->cities->count() > 2)
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                +{{ $contact->cities->count() - 2 }}
              </span>
            @endif
          </div>
        @endif
      </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">No contacts found</h3>
      <p class="mt-1 text-sm text-gray-500">
        @if(request('search'))
          Try adjusting your search terms.
        @else
          No contacts are available in the directory yet.
        @endif
      </p>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($contacts->hasPages())
    <div class="mt-8">
      {{ $contacts->appends(request()->query())->links() }}
    </div>
  @endif
</div>
@endsection