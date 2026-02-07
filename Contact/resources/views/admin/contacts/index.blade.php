@extends('layouts.admin')

@section('header_title', Auth::user()->role === 'admin' ? 'All Contacts' : 'My Contacts')

@section('content')
<div class="space-y-6" x-data="contactsManager()" x-init="init()">
  <!-- Page Header -->
  <div class="flex flex-wrap items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Gestion des Contacts</h1>
      <p class="text-sm text-slate-500 mt-1">
        {{ Auth::user()->role === 'admin' ? 'Gérez votre répertoire : ajoutez, modifiez ou supprimez vos contacts.' : 'Gérez votre réseau personnel de contacts.' }}
      </p>
    </div>
    <button type="button" @click="openCreateModal()" class="eco-btn-primary">
      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
      Ajouter un contact
    </button>
  </div>

  <!-- Success Message -->
  <div id="success-msg" class="text-emerald-600 font-medium h-6" x-text="successMessage"></div>

  <!-- Main Card -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <!-- Search & Filter Bar -->
    <div class="px-6 py-4 flex flex-wrap items-center justify-between gap-4 border-b border-slate-100">
      <form id="search-form" method="GET" action="{{ route('contacts.index') }}" class="flex items-center gap-3 flex-1">
        <!-- Search Input -->
        <div class="relative">
          <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input type="text" id="search-input" x-ref="searchInput" x-model="searchQuery" @input.debounce.300ms="fetchContacts()" name="search" value="{{ $search }}" placeholder="Rechercher un contact..." class="eco-search-input">
        </div>

        <!-- City Filter Dropdown -->
        <div class="relative">
          <select id="city-select" x-ref="citySelect" name="cities[]" class="eco-select" @change="selectedCities = $event.target.value ? [Number($event.target.value)] : []; fetchContacts()">
            <option value="">Sélectionner...</option>
            @foreach($cities as $city)
              <option value="{{ $city->id }}" {{ in_array($city->id, $cityFilter) ? 'selected' : '' }}>{{ $city->nom }}</option>
            @endforeach
          </select>
          @if(count($cityFilter) > 0)
          <button type="button" @click="selectedCities = []; $refs.citySelect.value = ''; fetchContacts()" class="absolute right-8 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          @endif
        </div>
      </form>
    </div>

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
</div>

@include('admin.contacts._modals')
@vite(['resources/js/contact.js'])
@endsection
