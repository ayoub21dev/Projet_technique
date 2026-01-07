@extends('layouts.admin')

@section('header_title', Auth::user()->role === 'admin' ? 'All Contacts' : 'My Contacts')

@section('content')
<!-- Table Section -->
<div class="flex flex-col">
  <div class="-m-1.5 overflow-x-auto">
    <div class="p-1.5 min-w-full inline-block align-middle">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
        <!-- Header -->
        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
              Contacts
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              @if(Auth::user()->role === 'admin')
                Manage all contacts across the system.
              @else
                Manage your personal network and connections.
              @endif
            </p>
          </div>

          <div>
            <div class="inline-flex gap-x-2">
              <button type="button" data-hs-overlay="#create-contact-modal" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z"/>
                  <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 13a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"/>
                </svg>
                Add contact
              </button>
            </div>
          </div>
        </div>
        <!-- End Header -->

        <!-- Table -->
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-slate-800 text-left">
            <tr>
              <th scope="col" class="ps-6 lg:ps-3 xl:ps-6 py-3 text-start">
                <div class="flex items-center gap-x-2">
                  <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Contact
                  </span>
                </div>
              </th>

              <th scope="col" class="px-6 py-3 text-start">
                <div class="flex items-center gap-x-2">
                  <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Phone
                  </span>
                </div>
              </th>

              <th scope="col" class="px-6 py-3 text-start">
                <div class="flex items-center gap-x-2">
                  <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Cities
                  </span>
                </div>
              </th>

              @if(Auth::user()->role === 'admin')
              <th scope="col" class="px-6 py-3 text-start">
                <div class="flex items-center gap-x-2">
                  <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                    Owner
                  </span>
                </div>
              </th>
              @endif

              <th scope="col" class="px-6 py-3 text-end"></th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($contacts as $contact)
                @include('admin.contacts.row', ['contact' => $contact])
            @empty
            <tr>
                <td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}" class="px-6 py-20 text-center text-sm text-gray-500">
                    No contacts found.
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
<!-- End Table Section -->

@include('admin.contacts.create_modal')
@include('admin.contacts.edit_modal')
@include('admin.contacts.delete_modal')
@include('admin.contacts.delete_script')

@endsection
