@extends('layouts.admin')

@section('header_title', Auth::user()->role === 'admin' ? 'All Contacts' : 'My Contacts')

@section('content')
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="modern-card border border-slate-200/60 rounded-xl shadow-lg overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 flex flex-wrap gap-3 justify-between items-center border-b border-slate-200/60 bg-gradient-to-r from-slate-50 to-white">
          <div>
            <h2 class="text-xl font-semibold text-slate-800">Contacts</h2>
            <p class="text-sm text-slate-600">
              {{ Auth::user()->role === 'admin' ? 'Manage all contacts across the system.' : 'Manage your personal network.' }}
            </p>
          </div>
          <button type="button" data-hs-overlay="#create-contact-modal" class="inline-flex items-center gap-x-2 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
            Add contact
          </button>
        </div>

        {{-- Search & Filter --}}
        <div class="px-6 py-4 border-b border-slate-200/60 bg-slate-50/50">
          <form method="GET" action="{{ route('contacts.index') }}" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, or phone..." class="flex-1 px-3 py-2 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">

            <div class="relative">
              <button type="button" id="cityDropdownButton" class="px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors flex items-center gap-2 min-w-[160px]">
                <span id="cityDropdownText" class="text-slate-600 truncate">{{ count($cityFilter) > 0 ? count($cityFilter).' cities' : 'All Cities' }}</span>
                <svg class="w-4 h-4 text-slate-400 transition-transform flex-shrink-0" id="cityDropdownIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>
              <div id="cityDropdownMenu" class="hidden absolute z-20 right-0 w-48 mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                <div class="p-2">
                  @foreach($cities as $city)
                  <label class="flex items-center px-3 py-2 hover:bg-slate-50 rounded-md cursor-pointer">
                    <input type="checkbox" name="cities[]" value="{{ $city->id }}" {{ in_array($city->id, $cityFilter) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mr-3" onchange="updateCityDropdownText()">
                    <span class="text-sm text-slate-700">{{ $city->nom }}</span>
                  </label>
                  @endforeach
                </div>
                @if(count($cities) > 0)
                <div class="border-t border-slate-200 p-2">
                  <button type="button" onclick="clearAllCities()" class="w-full text-left px-3 py-2 text-sm text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-md transition-colors">Clear All</button>
                </div>
                @endif
              </div>
            </div>

            <button type="submit" class="inline-flex items-center gap-x-2 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all duration-200">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm.6-3.844a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/></svg>
              Search
            </button>
            <a href="{{ route('contacts.index') }}" class="inline-flex items-center py-2 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-all duration-200">Clear</a>
          </form>
        </div>

        {{-- Table --}}
        <table class="min-w-full divide-y divide-slate-200">
          <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
            <tr>
              <th class="ps-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Contact</th>
              <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Phone</th>
              <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Cities</th>
              @if(Auth::user()->role === 'admin')
              <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Owner</th>
              @endif
              <th class="px-6 py-3 text-end"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 bg-white">
            @forelse($contacts as $contact)
              @include('admin.contacts.row', ['contact' => $contact])
            @empty
            <tr>
              <td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}" class="px-6 py-20 text-center text-sm text-slate-500">No contacts found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@include('admin.contacts._modals')
@include('admin.contacts._scripts')
@endsection
