@extends('layouts.guest')

@section('content')
@if(session('error'))
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-6">
    <div class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500" role="alert">
      <span class="font-bold">Error!</span> {{ session('error') }}
    </div>
  </div>
@endif
<!-- Hero -->
<div class="relative overflow-hidden before:absolute before:top-0 before:start-1/2 before:bg-[url('https://preline.co/assets/svg/examples/polygon-bg-element.svg')] before:bg-no-repeat before:bg-top before:bg-cover before:w-full before:h-full before:-z-[1] before:transform before:-translate-x-1/2 dark:before:bg-[url('https://preline.co/assets/svg/examples/polygon-bg-element-dark.svg')]">
  <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-10">
    <!-- Announcement Banner -->
    <div class="flex justify-center">
      <a class="inline-flex items-center gap-x-2 bg-white border border-gray-200 text-sm text-gray-800 p-1 px-3 rounded-full transition hover:border-gray-300 outline-none focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white" href="#">
        Explore our new features
        <span class="py-1.5 px-2.5 inline-flex justify-center items-center gap-x-1.5 bg-gray-200 font-semibold text-gray-600 text-[11px] rounded-full dark:bg-gray-800 dark:text-gray-400">
          <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
          </svg>
        </span>
      </a>
    </div>
    <!-- End Announcement Banner -->

    <!-- Title -->
    <div class="mt-5 max-w-2xl text-center mx-auto">
      <h1 class="block font-bold text-gray-800 text-4xl md:text-5xl lg:text-6xl">
        Professional Contact 
        <span class="bg-clip-text bg-gradient-to-tl from-blue-600 to-violet-600 text-transparent">Management</span>
      </h1>
    </div>
    <!-- End Title -->

    <div class="mt-5 max-w-3xl text-center mx-auto">
      <p class="text-lg text-gray-600">Organize your professional network with ease. Custom tags, location filtering, and beautiful profiles for all your connections.</p>
    </div>

    <!-- Buttons -->
    <div class="mt-8 gap-3 flex justify-center">
      @auth
        <a class="inline-flex justify-center items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 hover:from-violet-600 hover:to-blue-600 border border-transparent text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white py-3 px-4 transition-all duration-300" href="{{ route('dashboard') }}">
          Go to Dashboard
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
          </svg>
        </a>
      @else
        <a class="inline-flex justify-center items-center gap-x-3 text-center bg-gradient-to-tl from-blue-600 to-violet-600 hover:from-violet-600 hover:to-blue-600 border border-transparent text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white py-3 px-4 transition-all duration-300" href="{{ route('register') }}">
          Start Now
          <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
          </svg>
        </a>
      @endauth
    </div>
    <!-- End Buttons -->
  </div>
</div>
<!-- End Hero -->



  <!-- Contacts Grid -->
  <div class="mt-8 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($contacts as $contact)
    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl">
      <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl overflow-hidden">
        @if($contact->photo)
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-in-out" src="{{ asset('storage/' . $contact->photo) }}" alt="Contact Photo">
        @else
            <svg class="w-20 h-20 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        @endif
      </div>
      <div class="p-4 md:p-6 text-center">
        <h3 class="text-xl font-semibold text-gray-800">
          {{ $contact->prenom }} {{ $contact->nom }}
        </h3>
        <p class="mt-3 text-gray-500">
          {{ $contact->email }}
        </p>
        <div class="mt-4 flex flex-wrap justify-center gap-1">
            @foreach($contact->cities as $city)
                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $city->nom }}
                </span>
            @endforeach
        </div>
      </div>
    </div>
    @empty
    <div class="col-span-full text-center py-10">
      <p class="text-gray-500">No contacts found matching your criteria.</p>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  <div class="mt-6">
    {{ $contacts->links() }}
  </div>
</div>


@endsection
