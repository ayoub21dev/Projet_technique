<tr id="contact-row-{{ $contact->id }}" class="hover:bg-slate-50/50 transition-colors">
  <!-- Photo -->
  <td>
    <div class="flex-shrink-0 relative h-8 w-8">
      @if($contact->photo)
        <img class="h-8 w-8 rounded-full object-cover shadow-sm border border-slate-100" 
             src="{{ asset('storage/'.$contact->photo) }}" 
             alt="{{ $contact->prenom }}"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="hidden items-center justify-center h-8 w-8 rounded-full bg-slate-100 text-slate-400 border border-slate-200">
          <i class="fa-solid fa-image text-xs"></i>
        </div>
      @else
        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-slate-100 text-slate-400 border border-slate-200">
          <i class="fa-solid fa-image text-xs"></i>
        </div>
      @endif
    </div>
  </td>
  
  <!-- Name (Désignation) -->
  <td>
    <span class="font-semibold text-slate-800">{{ $contact->prenom }} {{ $contact->nom }}</span>
  </td>
  
  <!-- Phone (Prix style - colored) -->
  <td>
    <span class="price-text">{{ $contact->telephone }}</span>
  </td>
  
  <!-- Cities (Category badges) -->
  <td>
    <div class="flex flex-wrap gap-1.5">
      @foreach($contact->cities as $city)
        <span class="eco-badge eco-badge-blue">{{ $city->nom }}</span>
      @endforeach
    </div>
  </td>
  
  <!-- Email (Description style) -->
  <td>
    <span class="text-sm text-blue-600 hover:underline cursor-pointer">{{ $contact->email }}</span>
  </td>
  
  @if(Auth::check() && Auth::user()->role === 'admin')
  <!-- Owner -->
  <td>
    <span class="text-sm text-slate-600">{{ $contact->user->name ?? 'N/A' }}</span>
  </td>
  @endif
  
  <!-- Actions (Icon buttons) -->
  <td>
    <div class="flex items-center justify-end gap-1">
      <button type="button" @click="openEditModal({{ $contact->id }})" class="eco-action-btn edit" title="Modifier">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
      </button>
      <button type="button" @click="confirmDelete({{ $contact->id }})" class="eco-action-btn delete" title="Supprimer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </button>
    </div>
  </td>
</tr>
