@extends('layouts.admin')

@section('header_title', 'Dashboard')

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
  <!-- Card -->
  <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
    <div class="p-4 md:p-5 flex gap-x-4">
      <div class="flex-shrink-0 flex justify-center items-center w-[46px] h-[46px] bg-blue-100 text-blue-600 rounded-lg dark:bg-blue-800/20 dark:text-blue-500">
        <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>

      <div class="grow">
        <div class="flex items-center gap-x-2">
          <p class="text-xs uppercase tracking-wide text-gray-500">
            Total Contacts
          </p>
        </div>
        <div class="mt-1 flex items-center gap-x-2">
          <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">
            {{ $stats['total_contacts'] }}
          </h3>
        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->

  <!-- Card -->
  <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
    <div class="p-4 md:p-5 flex gap-x-4">
      <div class="flex-shrink-0 flex justify-center items-center w-[46px] h-[46px] bg-violet-100 text-violet-600 rounded-lg dark:bg-violet-800/20 dark:text-violet-500">
        <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
      </div>

      <div class="grow">
        <div class="flex items-center gap-x-2">
          <p class="text-xs uppercase tracking-wide text-gray-500">
            Active Cities
          </p>
        </div>
        <div class="mt-1 flex items-center gap-x-2">
          <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">
            {{ $stats['total_cities'] }}
          </h3>
        </div>
      </div>
    </div>
  </div>
  <!-- End Card -->
</div>

<!-- Table -->
<div class="mt-8 flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
              Recent Contacts
            </h2>
          </div>

          <div>
            <div class="inline-flex gap-x-2">
              <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('contacts.index') }}">
                View all
              </a>

              <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#create-contact-modal">
                <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"/>
                  <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 13a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"/>
                </svg>
                Create
              </button>
            </div>
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-slate-800 text-left">
            <tr>
              <th scope="col" class="px-6 py-3 text-start">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                  Name
                </span>
              </th>
              <th scope="col" class="px-6 py-3 text-start">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                  Email
                </span>
              </th>
              <th scope="col" class="px-6 py-3 text-start">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                  Added
                </span>
              </th>
              <th scope="col" class="px-6 py-3 text-end"></th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($stats['recent_contacts'] as $contact)
            <tr>
              <td class="h-px w-px whitespace-nowrap">
                <div class="px-6 py-3">
                  <div class="flex items-center gap-x-3">
                    @if($contact->photo)
                        <img class="inline-block h-[38px] w-[38px] rounded-full" src="{{ asset('storage/' . $contact->photo) }}" alt="Image Description">
                    @else
                        <span class="inline-flex items-center justify-center h-[38px] w-[38px] rounded-full bg-blue-600">
                          <span class="text-xs font-medium text-white leading-none">{{ substr($contact->nom, 0, 1) }}</span>
                        </span>
                    @endif
                    <div class="grow">
                      <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $contact->prenom }} {{ $contact->nom }}</span>
                    </div>
                  </div>
                </div>
              </td>
              <td class="h-px w-px whitespace-nowrap">
                <div class="px-6 py-3 text-sm text-gray-500">
                  {{ $contact->email }}
                </div>
              </td>
              <td class="h-px w-px whitespace-nowrap">
                <div class="px-6 py-3 text-sm text-gray-500">
                  {{ $contact->created_at->diffForHumans() }}
                </div>
              </td>
              <td class="h-px w-px whitespace-nowrap">
                <div class="px-6 py-1.5 text-end">
                  <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-red-900 dark:text-red-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="deleteContact('{{ $contact->id }}')">
                    Delete
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-20 text-center text-sm text-gray-500">
                    No contacts yet. Start by creating one!
                </td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <!-- End Table -->
      </div>
    </div>
  </div>
</div>
<!-- End Table -->
@include('admin.contacts.create_modal')
@include('admin.contacts.edit_modal')
@include('admin.contacts.delete_script')

@endsection
