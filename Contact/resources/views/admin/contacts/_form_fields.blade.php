<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
  <div>
    <label for="{{ $prefix }}-prenom" class="block text-sm font-medium text-slate-700 mb-1.5">Prénom <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-prenom" name="prenom" type="text" class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm placeholder-slate-400 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all" placeholder="Jean" required>
  </div>
  <div>
    <label for="{{ $prefix }}-nom" class="block text-sm font-medium text-slate-700 mb-1.5">Nom <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-nom" name="nom" type="text" class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm placeholder-slate-400 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all" placeholder="Dupont" required>
  </div>
  <div>
    <label for="{{ $prefix }}-email" class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-email" name="email" type="email" class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm placeholder-slate-400 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all" placeholder="jean@exemple.com" required>
  </div>
  <div>
    <label for="{{ $prefix }}-telephone" class="block text-sm font-medium text-slate-700 mb-1.5">Téléphone <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-telephone" name="telephone" type="text" class="block w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm placeholder-slate-400 bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition-all" placeholder="0612345678" required>
  </div>
</div>

<div class="mt-5">
  <label class="block text-sm font-medium text-slate-700 mb-2">Villes <span class="text-slate-400 font-normal">(optionnel)</span></label>
  <div class="flex flex-wrap gap-3 p-4 bg-slate-50 rounded-lg border border-slate-200">
    @foreach($cities as $city)
    <label class="flex items-center gap-2 cursor-pointer py-1.5 px-3 rounded-lg hover:bg-white transition-colors">
      <input type="checkbox" name="cities[]" value="{{ $city->id }}" id="{{ $prefix }}-city-{{ $city->id }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 focus:ring-offset-0">
      <span class="text-sm text-slate-600">{{ $city->nom }}</span>
    </label>
    @endforeach
  </div>
</div>

<div class="mt-5">
  <label for="{{ $prefix }}-photo" class="block text-sm font-medium text-slate-700 mb-1.5">Photo <span class="text-slate-400 font-normal">(optionnel)</span></label>
  <div class="relative">
    <input id="{{ $prefix }}-photo" name="photo" type="file" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer cursor-pointer border border-slate-200 rounded-lg bg-slate-50 transition-colors">
  </div>
  <p class="mt-1.5 text-xs text-slate-500">PNG, JPG ou GIF (max. 2MB)</p>
</div>
