<tr id="contact-row-{{ $contact->id }}" class="hover:bg-slate-50/50 transition-colors">
  <td class="ps-6 py-3">
    <div class="flex items-center gap-x-3">
      <div class="flex-shrink-0 relative">
        @if($contact->photo)
          <img class="h-10 w-10 rounded-full ring-2 ring-white shadow-sm object-cover relative z-10" 
               src="{{ asset('storage/'.$contact->photo) }}" 
               alt=""
               onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
        @endif
        <span class="placeholder-fallback {{ $contact->photo ? 'hidden' : '' }} flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600 border border-blue-200 shadow-sm">
          <span class="text-xs font-bold">{{ strtoupper(substr($contact->prenom, 0, 1)) }}{{ strtoupper(substr($contact->nom, 0, 1)) }}</span>
        </span>
      </div>
      <div>
        <span class="block text-sm font-semibold text-slate-800">{{ $contact->prenom }} {{ $contact->nom }}</span>
        <span class="block text-sm text-slate-500">{{ $contact->email }}</span>
      </div>
    </div>
  </td>
  <td class="px-6 py-3 text-sm text-slate-600">{{ $contact->telephone }}</td>
  <td class="px-6 py-3">
    <div class="flex flex-wrap gap-1">
      @foreach($contact->cities as $city)
        <span class="py-0.5 px-2 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-violet-100 text-blue-800 border border-blue-200">{{ $city->nom }}</span>
      @endforeach
    </div>
  </td>

  <td class="px-6 py-3 text-end">
    <div class="inline-flex gap-x-1">
      <button type="button" onclick="openEditModal({{ $contact->id }})" class="py-1.5 px-2.5 text-xs font-medium rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-1">Edit</button>
      <button type="button" onclick="deleteContact('{{ $contact->id }}')" class="py-1.5 px-2.5 text-xs font-medium rounded-lg bg-gradient-to-r from-red-100 to-red-200 text-red-800 hover:from-red-200 hover:to-red-300 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">Delete</button>
    </div>
  </td>
</tr>
