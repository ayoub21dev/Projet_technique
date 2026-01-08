@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
{{-- Stats Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
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

{{-- Recent Contacts Table --}}
<div class="mt-8 modern-card border border-slate-200/60 rounded-xl shadow-lg overflow-hidden">
  <div class="px-6 py-4 flex flex-wrap gap-3 justify-between items-center border-b border-slate-200/60 bg-gradient-to-r from-slate-50 to-white">
    <h2 class="text-xl font-semibold text-slate-800">Recent Contacts</h2>
    <div class="flex gap-x-2">
      <a href="{{ route('contacts.index') }}" class="inline-flex items-center gap-x-2 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">View all</a>
      <button type="button" data-hs-overlay="#create-contact-modal" class="inline-flex items-center gap-x-2 py-2 px-3 bg-gradient-to-r from-blue-600 to-violet-600 text-white text-sm font-semibold rounded-lg hover:from-blue-700 hover:to-violet-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/></svg>
        Create
      </button>
    </div>
  </div>

  <table class="min-w-full divide-y divide-slate-200">
    <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
      <tr>
        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Name</th>
        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Email</th>
        <th class="px-6 py-3 text-start text-xs font-semibold uppercase tracking-wide text-slate-700">Added</th>
        <th class="px-6 py-3 text-end"></th>
      </tr>
    </thead>
    <tbody class="divide-y divide-slate-200 bg-white">
      @forelse($stats['recent_contacts'] as $contact)
      <tr class="hover:bg-slate-50/50 transition-colors">
        <td class="px-6 py-3">
          <div class="flex items-center gap-x-3">
            @if($contact->photo)
              <img class="h-10 w-10 rounded-full ring-2 ring-white shadow-sm object-cover" src="{{ asset('storage/'.$contact->photo) }}" alt="">
            @else
              <span class="flex items-center justify-center h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-violet-600 shadow-sm">
                <span class="text-xs font-medium text-white">{{ substr($contact->nom, 0, 1) }}</span>
              </span>
            @endif
            <span class="text-sm font-semibold text-slate-800">{{ $contact->prenom }} {{ $contact->nom }}</span>
          </div>
        </td>
        <td class="px-6 py-3 text-sm text-slate-600">{{ $contact->email }}</td>
        <td class="px-6 py-3 text-sm text-slate-600">{{ $contact->created_at->diffForHumans() }}</td>
        <td class="px-6 py-3 text-end">
          <button type="button" onclick="deleteContact('{{ $contact->id }}')" class="py-1.5 px-2.5 text-xs font-medium rounded-lg bg-gradient-to-r from-red-100 to-red-200 text-red-800 hover:from-red-200 hover:to-red-300 transition-all">Delete</button>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="px-6 py-20 text-center text-sm text-slate-500">No contacts yet. Start by creating one!</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

@include('admin.contacts._modals')
@include('admin.contacts._scripts')
@endsection
