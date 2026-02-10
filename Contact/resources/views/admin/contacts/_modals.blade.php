{{-- Create Contact Modal --}}
<div id="create-contact-modal" x-show="showCreateModal" x-cloak @keydown.escape.window="closeCreateModal()" @click.self="closeCreateModal()" class="w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
  <div class="mt-7 opacity-100 ease-out transition-all sm:max-w-xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-slate-200 shadow-xl rounded-2xl">
      <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Ajouter un nouveau contact</h3>
          <p class="text-sm text-slate-500 mt-0.5">Remplissez les informations du contact</p>
        </div>
        <button type="button" class="modal-close w-8 h-8 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors flex items-center justify-center" @click="closeCreateModal()">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="p-6 overflow-y-auto max-h-[70vh]">
        <form id="create-contact-form" x-ref="createForm" @submit.prevent="submitCreateContact()" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.contacts._form_fields', ['prefix' => 'create'])
          <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" class="modal-close py-2.5 px-4 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200" @click="closeCreateModal()">
              Annuler
            </button>
            <button type="submit" class="eco-btn-primary" :disabled="createSubmitting" x-text="createSubmitting ? 'Creating...' : 'Créer le contact'"></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Contact Modal --}}
<div id="edit-contact-modal" x-show="showEditModal" x-cloak @keydown.escape.window="closeEditModal()" @click.self="closeEditModal()" class="w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
  <div class="mt-7 opacity-100 ease-out transition-all sm:max-w-xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border border-slate-200 shadow-xl rounded-2xl">
      <div class="flex justify-between items-center py-4 px-6 border-b border-slate-100">
        <div>
          <h3 class="text-lg font-bold text-slate-800">Modifier le contact</h3>
          <p class="text-sm text-slate-500 mt-0.5">Mettez à jour les informations</p>
        </div>
        <button type="button" class="modal-close w-8 h-8 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors flex items-center justify-center" @click="closeEditModal()">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="p-6 overflow-y-auto max-h-[70vh]">
        <form id="edit-contact-form" x-ref="editForm" @submit.prevent="submitEditContact()" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div id="current-photo-container" x-ref="currentPhotoContainer" class="mb-6 hidden">
            <label class="block text-sm font-medium text-slate-700 mb-2">Photo actuelle</label>
            <img id="current-photo-preview" x-ref="currentPhotoPreview" src="" alt="Current Photo" class="h-20 w-20 rounded-xl object-cover border-2 border-slate-200 shadow-sm">
          </div>
          @include('admin.contacts._form_fields', ['prefix' => 'edit'])
          <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="button" class="modal-close py-2.5 px-4 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200" @click="closeEditModal()">
              Annuler
            </button>
            <button type="submit" class="eco-btn-primary" :disabled="editSubmitting" x-text="editSubmitting ? 'Updating...' : 'Mettre à jour'"></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-contact-modal" x-show="showDeleteModal" x-cloak @keydown.escape.window="closeDeleteModal()" @click.self="closeDeleteModal()" class="fixed inset-0 z-[80] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
  <div class="w-full max-w-md m-3">
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
        <button type="button" class="modal-close py-2.5 px-4 text-sm font-medium rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300 transition-all duration-200" @click="closeDeleteModal()">
          Annuler
        </button>
        <button type="button" id="confirm-delete-btn" @click="submitDeleteContact()" :disabled="deleteSubmitting" class="py-2.5 px-4 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all duration-200 flex items-center gap-2">
          <span x-text="deleteSubmitting ? 'Deleting...' : 'Supprimer'"></span>
        </button>
      </div>
    </div>
  </div>
</div>
