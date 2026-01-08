@extends('layouts.admin')

@section('header_title', 'Cities Management')

@section('content')
<div class="grid lg:grid-cols-2 gap-4 sm:gap-6">
  <!-- Add City -->
  <div class="flex flex-col modern-card border border-slate-200/60 shadow-lg rounded-xl">
    <div class="px-6 py-4 border-b border-slate-200/60 bg-gradient-to-r from-slate-50 to-white">
        <h2 class="text-xl font-semibold text-slate-800">
            Add New City
        </h2>
    </div>
    <div class="p-6">
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nom" class="block text-sm font-medium mb-2 text-slate-700">City Name</label>
                    <input type="text" id="nom" name="nom" class="py-2 px-3 block w-full border-slate-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-white text-slate-800" placeholder="e.g. Casablanca" required>
                    @error('nom') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gradient-to-r from-blue-600 to-violet-600 text-white hover:from-blue-700 hover:to-violet-700 disabled:opacity-50 disabled:pointer-events-none shadow-lg hover:shadow-xl transition-all duration-200">
                    Add City
                </button>
            </div>
        </form>
    </div>
  </div>

  <!-- Cities List -->
  <div class="flex flex-col modern-card border border-slate-200/60 shadow-lg rounded-xl">
    <div class="px-6 py-4 border-b border-slate-200/60 text-left bg-gradient-to-r from-slate-50 to-white">
        <h2 class="text-xl font-semibold text-slate-800">
            Available Cities
        </h2>
    </div>
    <div class="p-1.5 min-w-full inline-block align-middle">
        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-slate-600 uppercase">Name</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-slate-600 uppercase">Contacts</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-slate-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($cities as $city)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $city->nom }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $city->contacts_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                            <form action="{{ route('cities.destroy', $city) }}" method="POST" onsubmit="return confirm('Delete this city?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors duration-150">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-slate-500">No cities added.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@endsection
