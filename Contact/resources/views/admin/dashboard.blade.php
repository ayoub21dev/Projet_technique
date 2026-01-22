@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')


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
