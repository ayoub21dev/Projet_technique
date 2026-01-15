<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    @forelse($contacts as $contact)
        @include('contacts._item', ['contact' => $contact])
    @empty
        <div class="col-span-full py-20 text-center glass rounded-3xl border border-white">
            <div class="bg-indigo-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <p class="text-slate-500 font-medium">Aucun contact trouvé.</p>
        </div>
    @endforelse
</div>
