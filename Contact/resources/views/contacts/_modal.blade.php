<div id="contactModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
            <h3 id="modalTitle" class="text-lg font-bold text-gray-800">Ajouter un Contact</h3>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form id="contactForm" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="methodField"></div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                    <input type="text" name="telephone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Villes (Plusieurs choix possibles)</label>
                    <select name="cities[]" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all h-32">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->nom }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs villes.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Photo</label>
                    <input type="file" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex gap-3">
                <button type="button" id="cancelBtn" class="flex-1 py-2.5 px-4 bg-white border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-all">Annuler</button>
                <button type="submit" class="flex-1 py-2.5 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 shadow-sm transition-all focus:ring-4 focus:ring-blue-200">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
