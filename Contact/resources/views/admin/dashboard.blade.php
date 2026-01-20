@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
  <div class="modern-card border border-slate-200/60 shadow-lg rounded-xl p-5 flex gap-x-4">
    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-100 to-violet-100 text-blue-600 rounded-lg shadow-sm">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </div>
    <div>
      <p class="text-xs uppercase tracking-wide text-slate-500">Total Contacts</p>
      <h3 class="text-xl font-medium text-slate-800">{{ $stats['total_contacts'] }}</h3>
    </div>
  </div>

  <div class="modern-card border border-slate-200/60 shadow-lg rounded-xl p-5 flex gap-x-4">
    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-violet-100 to-purple-100 text-violet-600 rounded-lg shadow-sm">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    </div>
    <div>
      <p class="text-xs uppercase tracking-wide text-slate-500">Active Cities</p>
      <h3 class="text-xl font-medium text-slate-800">{{ $stats['total_cities'] }}</h3>
    </div>
  </div>
</div>

{{-- Contacts Section Matching User Request --}}
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Contacts</h1>
        <div id="success-msg" class="text-green-600 font-medium h-6"></div>
    </div>

    <div class="flex gap-4 justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form id="search-form" class="w-full max-w-sm" method="GET" action="{{ route('dashboard') }}">
            <input type="text" id="search-input" name="search" value="{{ $search ?? '' }}" class="py-2 px-4 w-full border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Search...">
        </form>
        <button type="button" data-hs-overlay="#create-contact-modal" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm">
            Add Contact
        </button>
    </div>

    <div class="border border-slate-200 rounded-lg overflow-hidden bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 uppercase text-xs text-gray-500 font-semibold">
                <tr>
                    <th class="px-6 py-3 text-start">Contact</th>
                    <th class="px-6 py-3 text-start">Phone</th>
                    <th class="px-6 py-3 text-start">Cities</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="px-6 py-3 text-start">Owner</th>
                    @endif
                    <th class="px-6 py-3 text-end">Actions</th>
                </tr>
            </thead>
            <tbody id="contacts-table-body" class="divide-y divide-gray-200">
                @include('admin.contacts.rows', ['contacts' => $contacts])
            </tbody>
        </table>
    </div>
</div>

@include('admin.contacts._modals')
@vite(['resources/js/contact.js'])
@endsection
