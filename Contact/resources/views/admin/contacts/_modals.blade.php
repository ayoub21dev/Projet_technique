{{-- Create Contact Modal --}}
<div id="create-contact-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
      <div class="flex justify-between items-center py-3 px-4 border-b">
        <h3 class="font-bold text-slate-800">Add New Contact</h3>
        <button type="button" class="modal-close w-7 h-7 rounded-full text-slate-600 hover:bg-slate-100" data-modal="create-contact-modal">
          <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="p-4 overflow-y-auto max-h-[70vh]">
        <form id="create-contact-form" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.contacts._form_fields', ['prefix' => 'create'])
          <div class="mt-6 flex justify-end gap-x-2">
            <button type="button" class="modal-close py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2" data-modal="create-contact-modal">Cancel</button>
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-blue-600 to-violet-600 text-white hover:from-blue-700 hover:to-violet-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Create Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Contact Modal --}}
<div id="edit-contact-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none bg-slate-900/50">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto">
      <div class="flex justify-between items-center py-3 px-4 border-b">
        <h3 class="font-bold text-slate-800">Edit Contact</h3>
        <button type="button" class="modal-close w-7 h-7 rounded-full text-slate-600 hover:bg-slate-100" data-modal="edit-contact-modal">
          <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>
      <div class="p-4 overflow-y-auto max-h-[70vh]">
        <form id="edit-contact-form" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div id="current-photo-container" class="mb-4 hidden">
            <img id="current-photo-preview" src="" alt="Current Photo" class="h-16 w-16 rounded-full object-cover">
          </div>
          @include('admin.contacts._form_fields', ['prefix' => 'edit'])
          <div class="mt-6 flex justify-end gap-x-2">
            <button type="button" class="modal-close py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2" data-modal="edit-contact-modal">Cancel</button>
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg bg-gradient-to-r from-blue-600 to-violet-600 text-white hover:from-blue-700 hover:to-violet-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-contact-modal" class="hs-overlay hidden fixed inset-0 z-[80] flex items-center justify-center bg-black/50 p-4 pointer-events-none">
  <div class="w-full max-w-sm m-3 pointer-events-auto shadow-lg rounded-xl">
    <div class="bg-white border rounded-xl shadow-sm p-6">
      <h3 class="text-xl font-bold text-slate-800 mb-4">Confirm Deletion</h3>
      <p class="text-slate-600 mb-6">Are you sure you want to delete this contact? This action cannot be undone.</p>
      <div class="flex justify-end gap-x-2">
        <button type="button" class="modal-close py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2" data-modal="delete-contact-modal">Cancel</button>
        <button type="button" id="confirm-delete-btn" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Confirm</button>
      </div>
    </div>
  </div>
</div>


