@extends('layouts.guest')

@section('title', 'Directory - ConnectHub')

@section('content')
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
  <!-- Title -->
  <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
    <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">Public Directory</h2>
    <p class="mt-1 text-gray-600 dark:text-gray-400">Discover professionals and experts in our network.</p>
  </div>
  <!-- End Title -->

  <!-- Grid -->
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($contacts as $contact)
    <!-- Card -->
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
      <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl overflow-hidden">
        @if($contact->photo)
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out" src="{{ asset('storage/' . $contact->photo) }}" alt="Contact Photo">
        @else
            <svg class="w-20 h-20 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        @endif
      </div>
      <div class="p-4 md:p-6 text-center">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-300 dark:hover:text-white">
          {{ $contact->prenom }} {{ $contact->nom }}
        </h3>
        <p class="mt-3 text-gray-500">
          {{ $contact->email }}
        </p>
        <div class="mt-4 flex flex-wrap justify-center gap-1">
            @foreach($contact->cities as $city)
                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-500">
                    {{ $city->nom }}
                </span>
            @endforeach
        </div>
      </div>
      <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="mailto:{{ $contact->email }}">
          Email
        </a>
        <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="tel:{{ $contact->telephone }}">
          Call
        </a>
      </div>
    </div>
    <!-- End Card -->
    @empty
    <div class="col-span-full text-center py-20">
        <p class="text-gray-500">No public contacts available at the moment.</p>
    </div>
    @endforelse
  </div>
  <!-- End Grid -->
</div>
@endsection
