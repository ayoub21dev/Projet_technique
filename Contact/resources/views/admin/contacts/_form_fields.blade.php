<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div>
    <label for="{{ $prefix }}-prenom" class="block text-sm font-medium text-slate-700 mb-1">First Name <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-prenom" name="prenom" type="text" class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="John" required>
  </div>
  <div>
    <label for="{{ $prefix }}-nom" class="block text-sm font-medium text-slate-700 mb-1">Last Name <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-nom" name="nom" type="text" class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Doe" required>
  </div>
  <div>
    <label for="{{ $prefix }}-email" class="block text-sm font-medium text-slate-700 mb-1">Email <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-email" name="email" type="email" class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="john@example.com" required>
  </div>
  <div>
    <label for="{{ $prefix }}-telephone" class="block text-sm font-medium text-slate-700 mb-1">Phone <span class="text-red-500">*</span></label>
    <input id="{{ $prefix }}-telephone" name="telephone" type="text" class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="0612345678" required>
  </div>
</div>

<div class="mt-4">
  <label class="block text-sm font-medium text-slate-700 mb-2">Cities / Tags</label>
  <div class="flex flex-wrap gap-x-6 gap-y-2">
    @foreach($cities as $city)
    <label class="flex items-center cursor-pointer">
      <input type="checkbox" name="cities[]" value="{{ $city->id }}" id="{{ $prefix }}-city-{{ $city->id }}" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500 mr-2">
      <span class="text-sm text-slate-600">{{ $city->nom }}</span>
    </label>
    @endforeach
  </div>
</div>

<div class="mt-4">
  <label for="{{ $prefix }}-photo" class="block text-sm font-medium text-slate-700 mb-1">Photo</label>
  <input id="{{ $prefix }}-photo" name="photo" type="file" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-colors">
</div>
