<div id="contactModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Ajouter un Contact</h3>
            <button type="button" class="close-btn text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form id="contactForm" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nom" placeholder="Nom" required class="w-full px-4 py-2 border rounded-lg">
                    <input type="text" name="prenom" placeholder="Prénom" required class="w-full px-4 py-2 border rounded-lg">
                </div>
                <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded-lg">
                <input type="text" name="telephone" placeholder="Téléphone" required class="w-full px-4 py-2 border rounded-lg">
                
                <select name="cities[]" multiple class="w-full px-4 py-2 border rounded-lg h-32">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->nom }}</option>
                    @endforeach
                </select>
                
                <input type="file" name="photo" class="block w-full text-sm text-gray-500">
            </div>

            <div class="px-6 py-4 bg-gray-50 flex gap-3">
                <button type="button" class="close-btn flex-1 py-2 px-4 bg-white border rounded-lg">Annuler</button>
                <button type="submit" class="flex-1 py-2 px-4 bg-blue-600 text-white rounded-lg">Enregistrer</button>
            </div>
        </form>
    </div>
</div>