<div class="glass p-5 rounded-3xl border border-white hover:border-indigo-100 transition-all flex items-center gap-4 group">
    <div class="w-16 h-16 rounded-2xl overflow-hidden bg-indigo-50 flex-shrink-0">
        @if($contact->photo)
            <img src="{{ asset('storage/' . $contact->photo) }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center text-indigo-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
            </div>
        @endif
    </div>
    <div class="flex-1 min-w-0">
        <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors truncate">
            {{ $contact->nom }} {{ $contact->prenom }}
        </h3>
        <p class="text-sm text-slate-500 flex items-center gap-1.5 truncate">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            {{ $contact->email }}
        </p>
        <p class="text-sm text-slate-400 mt-1 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            {{ $contact->telephone }}
        </p>
    </div>
</div>
