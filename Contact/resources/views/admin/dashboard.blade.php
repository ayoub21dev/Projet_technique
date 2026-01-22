@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')


{{-- Contacts Section Matching User Request --}}
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Contacts</h1>
        <div id="success-msg" class="text-green-600 font-medium h-6"></div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <form id="search-form" method="GET" action="{{ route('dashboard') }}" class="flex flex-col lg:flex-row gap-4">
            {{-- Search Bar --}}
            <div class="relative flex-grow group">
                <input type="text" id="search-input" name="search" value="{{ $search ?? '' }}" 
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
                    <button type="button" id="cityDropdownButton" class="w-full h-[48px] flex items-center justify-between px-4 border border-slate-300 rounded-xl bg-white hover:bg-slate-50 focus:ring-2 focus:ring-blue-500 outline-none transition-all group">
                        <div class="flex items-center gap-2 truncate">
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            </svg>
                            <span id="cityDropdownText" class="text-sm text-slate-600 truncate">
                                @if(count($selectedCities ?? []) > 0)
                                    {{ count($selectedCities) }} Cities Selected
                                @else
                                    All Cities
                                @endif
                            </span>
                        </div>
                        <svg id="cityDropdownIcon" class="w-4 h-4 text-slate-400 transition-transform duration-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div id="cityDropdownMenu" class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden animate-in fade-in slide-in-from-top-1 duration-200">
                        <div class="p-2.5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cities</span>
                            <button type="button" onclick="clearAllCities()" class="text-[11px] text-blue-600 hover:text-blue-700 font-bold uppercase">Reset</button>
                        </div>
                        <div class="max-h-60 overflow-y-auto p-1.5 space-y-0.5">
                            @foreach($cities as $city)
                            <label class="flex items-center p-2 rounded-lg hover:bg-blue-50 cursor-pointer transition-colors group">
                                <input type="checkbox" name="cities[]" value="{{ $city->id }}" 
                                    class="filter-city-checkbox w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 transition-colors"
                                    @if(in_array($city->id, $selectedCities ?? [])) checked @endif>
                                <span class="ml-3 text-sm text-slate-600 group-hover:text-slate-900 transition-colors">{{ $city->nom }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Add Button --}}
                <button type="button" data-hs-overlay="#create-contact-modal" class="whitespace-nowrap h-[48px] px-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Contact
                </button>
            </div>
        </form>
    </div>

    <div class="border border-slate-200 rounded-lg overflow-hidden bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 uppercase text-xs text-gray-500 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-start">Contact</th>
                    <th class="px-6 py-3 text-start">Phone</th>
                    <th class="px-6 py-3 text-start">Cities</th>

                    <th class="px-6 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="contacts-table-body" class="divide-y divide-gray-200">
                @include('admin.contacts.rows', ['contacts' => $contacts])
            </tbody>
        </table>
    </div>

    {{-- Pagination Container --}}
    <div id="pagination-container" class="mt-4 flex justify-center">
        {{ $contacts->appends(request()->all())->links() }}
    </div>
</div>

@include('admin.contacts._modals')
@vite(['resources/js/contact.js'])
@endsection
