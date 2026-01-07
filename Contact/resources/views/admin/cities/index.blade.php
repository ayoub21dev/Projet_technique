@extends('layouts.admin')

@section('header_title', 'Cities Management')

@section('content')
<div class="grid lg:grid-cols-2 gap-4 sm:gap-6">
  <!-- Add City -->
  <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Add New City
        </h2>
    </div>
    <div class="p-6">
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nom" class="block text-sm font-medium mb-2 dark:text-white">City Name</label>
                    <input type="text" id="nom" name="nom" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="e.g. Casablanca" required>
                    @error('nom') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Add City
                </button>
            </div>
        </form>
    </div>
  </div>

  <!-- Cities List -->
  <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 text-left">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Available Cities
        </h2>
    </div>
    <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Contacts</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($cities as $city)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $city->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $city->contacts_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                            <form action="{{ route('cities.destroy', $city) }}" method="POST" onsubmit="return confirm('Delete this city?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No cities added.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection
