<tr id="contact-row-{{ $contact->id }}">
  <td class="h-px w-px whitespace-nowrap">
    <div class="ps-6 lg:ps-3 xl:ps-6 py-3">
      <div class="flex items-center gap-x-3">
        @if($contact->photo)
            <img class="inline-block h-[38px] w-[38px] rounded-full" src="{{ asset('storage/' . $contact->photo) }}" alt="Contact Photo">
        @else
            <span class="inline-flex items-center justify-center h-[38px] w-[38px] rounded-full bg-blue-600">
              <span class="text-xs font-medium text-white leading-none">{{ substr($contact->nom, 0, 1) }}</span>
            </span>
        @endif
        <div class="grow">
          <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $contact->prenom }} {{ $contact->nom }}</span>
          <span class="block text-sm text-gray-500">{{ $contact->email }}</span>
        </div>
      </div>
    </div>
  </td>
  <td class="h-px w-72 whitespace-nowrap">
    <div class="px-6 py-3">
      <span class="text-sm text-gray-500">{{ $contact->telephone }}</span>
    </div>
  </td>
  <td class="h-px w-px whitespace-nowrap">
    <div class="px-6 py-3">
        <div class="flex flex-wrap gap-1">
            @foreach($contact->cities as $city)
                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-500">
                    {{ $city->nom }}
                </span>
            @endforeach
        </div>
    </div>
  </td>
  @if(Auth::user()->role === 'admin')
  <td class="h-px w-px whitespace-nowrap">
    <div class="px-6 py-3">
      <span class="block text-sm text-gray-800 dark:text-gray-200">{{ $contact->user->name }}</span>
      <span class="block text-xs text-gray-500">{{ $contact->user->email }}</span>
    </div>
  </td>
  @endif
  <td class="h-px w-px whitespace-nowrap">
    <div class="px-6 py-1.5 text-end">
        <div class="inline-flex gap-x-1">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="openEditModal({{ $contact->id }})">
              Edit
            </button>
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-red-900 dark:text-red-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="deleteContact('{{ $contact->id }}')">
              Delete
            </button>
        </div>
    </div>
  </td>
</tr>
