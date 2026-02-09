@extends('layouts.admin')

@section('header_title', Auth::user()->role === 'admin' ? 'All Contacts' : 'My Contacts')

@section('content')
<div class="space-y-6" x-data="contactsManager()" x-init="init()">
  <!-- Page Header -->
  <div class="flex flex-wrap items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
      <p class="text-sm text-slate-500 mt-1">
        {{ Auth::user()->role === 'admin' ? 'Manage all contacts in one place.' : 'Manage your personal network.' }}
      </p>
    </div>
    <div id="success-msg" class="text-emerald-600 font-medium h-6" x-text="successMessage"></div>
  </div>

  <!-- Main Card -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
    <form id="search-form" method="GET" action="{{ route('contacts.index') }}" class="flex flex-col lg:flex-row gap-4">
      {{-- Search Bar --}}
      <div class="relative flex-grow group">
        <input type="text" id="search-input" name="search" value="{{ $search }}" x-ref="searchInput" x-model="searchQuery" @input.debounce.300ms="fetchContacts()"
          class="h-[48px] px-4 pl-10 w-full border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50/50 focus:bg-white transition-all outline-none"
          placeholder="Search by name, email, or phone...">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>

      {{-- Controls Group --}}
      <div class="flex flex-col sm:flex-row gap-3">
        {{-- City Filter --}}
        <div class="relative w-full sm:w-64">
          <button type="button" id="cityDropdownButton" @click="cityDropdownOpen = !cityDropdownOpen" class="w-full h-[48px] flex items-center justify-between px-4 border border-slate-300 rounded-xl bg-white hover:bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all group">
            <div class="flex items-center gap-2 truncate">
              <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              </svg>
              <span id="cityDropdownText" class="text-sm text-slate-600 truncate" x-text="cityText()"></span>
            </div>
            <svg id="cityDropdownIcon" class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" :style="cityDropdownOpen ? 'transform: rotate(180deg);' : 'transform: rotate(0deg);'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          
          <div id="cityDropdownMenu" x-show="cityDropdownOpen" @click.outside="cityDropdownOpen = false" x-cloak class="absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden animate-in fade-in slide-in-from-top-1 duration-200">
            <div class="p-2.5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
              <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cities</span>
              <button type="button" @click.prevent="clearCities()" class="text-[11px] text-blue-600 hover:text-blue-700 font-bold uppercase">Reset</button>
            </div>
            <div class="max-h-60 overflow-y-auto p-1.5 space-y-0.5">
              @foreach($cities as $city)
              <label class="flex items-center p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors group">
                <input type="checkbox" name="cities[]" value="{{ $city->id }}"
                  class="filter-city-checkbox w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 transition-colors"
                  @change="toggleCity({{ $city->id }}, $event.target.checked)"
                  {{ in_array($city->id, $cityFilter) ? 'checked' : '' }}>
                <span class="ml-3 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">{{ $city->nom }}</span>
              </label>
              @endforeach
            </div>
          </div>
        </div>

        {{-- Add Button --}}
        <button type="button" @click="openCreateModal()" class="whitespace-nowrap h-[48px] px-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          New Contact
        </button>
      </div>
    </form>
  </div>

  <!-- Main Table Card -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="eco-table w-full">
        <thead>
          <tr>
            <th class="text-left">Photo</th>
            <th class="text-left">Désignation</th>
            <th class="text-left">Téléphone</th>
            <th class="text-left">Villes</th>
            <th class="text-left">Email</th>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <th class="text-left">Propriétaire</th>
            @endif
            <th class="text-right">Actions</th>
          </tr>
        </thead>
        <tbody id="contacts-table-body" x-ref="contactsTableBody">
          @include('admin.contacts.rows')
        </tbody>
      </table>
    </div>

    <!-- Footer with Pagination -->
    <div class="px-6 py-4 flex items-center justify-between border-t border-slate-100 bg-slate-50/50">
      <p class="text-sm text-slate-500">
        Showing <span class="font-medium">{{ $contacts->firstItem() ?? 0 }}</span> to <span class="font-medium">{{ $contacts->lastItem() ?? 0 }}</span> of <span class="font-medium">{{ $contacts->total() }}</span> results
      </p>
      
      @if($contacts->hasPages())
      <div id="pagination-container" x-ref="paginationContainer" class="eco-pagination">
        {{-- Previous Page --}}
        @if($contacts->onFirstPage())
          <span class="eco-pagination-btn opacity-50 cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </span>
        @else
          <a href="{{ $contacts->previousPageUrl() }}" class="eco-pagination-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          </a>
        @endif

        {{-- Page Numbers --}}
        @foreach($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
          @if($page == $contacts->currentPage())
            <span class="eco-pagination-btn active">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="eco-pagination-btn">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next Page --}}
        @if($contacts->hasMorePages())
          <a href="{{ $contacts->nextPageUrl() }}" class="eco-pagination-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </a>
        @else
          <span class="eco-pagination-btn opacity-50 cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          </span>
        @endif
      </div>
      @endif
    </div>
  </div>
  @include('admin.contacts._modals')
</div>

@vite(['resources/js/contact.js'])
@endsection
