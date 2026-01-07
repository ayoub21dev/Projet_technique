@extends('layouts.admin')

@section('header_title', isset($contact) ? 'Edit Contact' : 'Create Contact')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
  <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
      Contact Information
    </h2>
  </div>

  <div class="p-6">
    <form action="{{ isset($contact) ? route('contacts.update', $contact) : route('contacts.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @if(isset($contact))
        @method('PUT')
      @endif

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- First Name -->
        <div class="space-y-2">
          <label for="prenom" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-gray-200">
            First Name
          </label>
          <input id="prenom" name="prenom" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="John" value="{{ old('prenom', $contact->prenom ?? '') }}" required>
          @error('prenom') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
        </div>

        <!-- Last Name -->
        <div class="space-y-2">
          <label for="nom" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-gray-200">
            Last Name
          </label>
          <input id="nom" name="nom" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Doe" value="{{ old('nom', $contact->nom ?? '') }}" required>
          @error('nom') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div class="space-y-2">
          <label for="email" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-gray-200">
            Email
          </label>
          <input id="email" name="email" type="email" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="john@example.com" value="{{ old('email', $contact->email ?? '') }}" required>
          @error('email') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
        </div>

        <!-- Phone -->
        <div class="space-y-2">
          <label for="telephone" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-gray-200">
            Phone
          </label>
          <input id="telephone" name="telephone" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="0612345678" value="{{ old('telephone', $contact->telephone ?? '') }}" required>
          @error('telephone') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
        </div>
      </div>

      <!-- Cities -->
      <div class="mt-6 space-y-2">
        <label class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-gray-200">
          Cities / Tags
        </label>
        <div class="flex flex-wrap gap-x-6">
          @foreach($cities as $city)
          <div class="flex">
            <input type="checkbox" name="cities[]" value="{{ $city->id }}" id="city-{{ $city->id }}" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" {{ in_array($city->id, old('cities', isset($contact) ? $contact->cities->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
            <label for="city-{{ $city->id }}" class="text-sm text-gray-500 ms-3 dark:text-gray-400">{{ $city->nom }}</label>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Photo -->
      <div class="mt-6 space-y-2">
        <label for="photo" class="inline-block text-sm font-medium text-gray-800 mt-2.5 dark:text-gray-200">
          Photo
        </label>
        <div class="flex items-center gap-x-5">
            @if(isset($contact) && $contact->photo)
                <img class="inline-block h-16 w-16 rounded-full ring-2 ring-white dark:ring-gray-800" src="{{ asset('storage/' . $contact->photo) }}" alt="Current Photo">
            @endif
            <input id="photo" name="photo" type="file" class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:disabled:opacity-50 file:disabled:pointer-events-none dark:file:bg-blue-500 dark:hover:file:bg-blue-400">
        </div>
        @error('photo') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
      </div>

      <div class="mt-8 flex justify-end gap-x-2">
        <a href="{{ route('contacts.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
          Cancel
        </a>
        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
          {{ isset($contact) ? 'Update' : 'Create' }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
