@forelse($contacts as $contact)
    <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="h-10 w-10 rounded-lg bg-gray-100 overflow-hidden border border-gray-200">
                @if($contact->photo)
                    <img src="{{ asset('storage/' . $contact->photo) }}" alt="" class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                @endif
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            {{ $contact->nom }} {{ $contact->prenom }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
            {{ $contact->email }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
            {{ $contact->telephone }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
            @foreach($contact->cities as $city)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                    {{ $city->nom }}
                </span>
            @endforeach
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium space-x-2">
            <button type="button" 
                class="edit-btn inline-flex items-center gap-x-1.5 text-blue-600 hover:text-blue-800 focus:outline-none"
                data-id="{{ $contact->id }}"
                data-nom="{{ $contact->nom }}"
                data-prenom="{{ $contact->prenom }}"
                data-email="{{ $contact->email }}"
                data-telephone="{{ $contact->telephone }}"
                data-cities="{{ json_encode($contact->cities->pluck('id')) }}">
                Modifier
            </button>
            <button type="button" 
                class="delete-btn inline-flex items-center gap-x-1.5 text-red-600 hover:text-red-800 focus:outline-none"
                data-id="{{ $contact->id }}">
                Supprimer
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
            Aucun contact trouvé.
        </td>
    </tr>
@endforelse
