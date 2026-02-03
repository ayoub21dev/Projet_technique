{{-- Create Contact Modal --}}
<div id="create-contact-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none bg-slate-900/50 backdrop-blur-sm">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-slate-200 shadow-xl rounded-2xl pointer-events-auto">
      <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Ajouter un nouveau contact</h3>
          <p class="text-sm text-slate-500 mt-0.5">Remplissez les informations du contact</p>
        </div>
        <button type="button" class="modal-close w-8 h-8 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors flex items-center justify-center" data-modal="create-contact-modal">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="p-6 overflow-y-auto max-h-[70vh]">
        <form id="create-contact-form" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.contacts._form_fields', ['prefix' => 'create'])
          <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" class="modal-close py-2.5 px-4 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200" data-modal="create-contact-modal">
              Annuler
            </button>
            <button type="submit" class="eco-btn-primary">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
              Créer le contact
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Contact Modal --}}
<div id="edit-contact-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none bg-slate-900/50 backdrop-blur-sm">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-slate-200 shadow-xl rounded-2xl pointer-events-auto">
      <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Modifier le contact</h3>
          <p class="text-sm text-slate-500 mt-0.5">Mettez à jour les informations</p>
        </div>
        <button type="button" class="modal-close w-8 h-8 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors flex items-center justify-center" data-modal="edit-contact-modal">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="p-6 overflow-y-auto max-h-[70vh]">
        <form id="edit-contact-form" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div id="current-photo-container" class="mb-6 hidden">
            <label class="block text-sm font-medium text-slate-700 mb-2">Photo actuelle</label>
            <img id="current-photo-preview" src="" alt="Current Photo" class="h-20 w-20 rounded-xl object-cover border-2 border-slate-200 shadow-sm">
          </div>
          @include('admin.contacts._form_fields', ['prefix' => 'edit'])
          <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" class="modal-close py-2.5 px-4 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200" data-modal="edit-contact-modal">
              Annuler
            </button>
            <button type="submit" class="eco-btn-primary">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              Mettre à jour
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-contact-modal" class="hs-overlay hidden fixed inset-0 z-[80] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 pointer-events-none">
  <div class="w-full max-w-md m-3 pointer-events-auto">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-xl p-6">
      <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
        </div>
        <div>
          <h3 class="text-lg font-bold text-slate-800">Confirmer la suppression</h3>
          <p class="text-sm text-slate-500 mt-1">Cette action est irréversible.</p>
        </div>
      </div>
      <p class="text-slate-600 mb-6">Êtes-vous sûr de vouloir supprimer ce contact ? Toutes les données associées seront définitivement perdues.</p>
      <div class="flex justify-end gap-3">
        <button type="button" class="modal-close py-2.5 px-4 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200" data-modal="delete-contact-modal">
          Annuler
        </button>
        <button type="button" id="confirm-delete-btn" class="py-2.5 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all duration-200 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
          Supprimer
        </button>
      </div>
    </div>
  </div>
</div>
