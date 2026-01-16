@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Contacts</h1>
            <div id="success-msg" class="text-green-600 font-medium h-6"></div>
        </div>

        <div class="flex gap-4 justify-between items-center bg-white p-4 rounded-xl shadow-sm border">
            <form id="searchForm" class="w-full max-w-sm">
                <input type="text" id="search" name="query" class="py-2 px-4 w-full border rounded-lg"
                    placeholder="Rechercher...">
            </form>
            <button type="button" id="openModal" class="py-2 px-4 bg-blue-600 text-white rounded-lg">Ajouter
                Contact</button>
        </div>

        <div class="border rounded-lg overflow-hidden bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 uppercase text-xs text-gray-500 font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-start">Photo</th>
                        <th class="px-6 py-3 text-start">Nom</th>
                        <th class="px-6 py-3 text-start">Email</th>
                        <th class="px-6 py-3 text-start">Téléphone</th>
                        <th class="px-6 py-3 text-start">Villes</th>
                        <th class="px-6 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody id="contacts-table" class="divide-y divide-gray-200">
                    @include('contacts._table_body', ['contacts' => $contacts])
                </tbody>
            </table>
        </div>
    </div>

    @include('contacts._modal')

    @push('scripts')
        <script>     window.CONTACT_ROUTES = {         index: "{{ route('contacts.index') }}",         store: "{{ route('contacts.store') }}"     };
        </script>
        @vite('resources/js/contacts.js')
    @endpush
@endsection