<!-- Edit Contact Modal -->
<div id="edit-contact-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none bg-gray-900/50">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
        <h3 class="font-bold text-gray-800 dark:text-white">
          Edit Contact
        </h3>
        <button type="button" class="flex justify-center items-center w-7 h-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="closeEditModal()">
          <span class="sr-only">Close</span>
          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>

      <!-- Body -->
      <div class="p-4 overflow-y-auto max-h-[70vh]">
        <form id="edit-contact-form" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="source" value="{{ request()->routeIs('dashboard') ? 'dashboard' : 'index' }}">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- First Name -->
            <div class="space-y-2">
              <label for="edit-prenom" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                First Name <span class="text-red-500">*</span>
              </label>
              <input id="edit-prenom" name="prenom" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
            </div>

            <!-- Last Name -->
            <div class="space-y-2">
              <label for="edit-nom" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                Last Name <span class="text-red-500">*</span>
              </label>
              <input id="edit-nom" name="nom" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
            </div>

            <!-- Email -->
            <div class="space-y-2">
              <label for="edit-email" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                Email <span class="text-red-500">*</span>
              </label>
              <input id="edit-email" name="email" type="email" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
            </div>

            <!-- Phone -->
            <div class="space-y-2">
              <label for="edit-telephone" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                Phone <span class="text-red-500">*</span>
              </label>
              <input id="edit-telephone" name="telephone" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" required>
            </div>
          </div>

          <!-- Cities -->
          <div class="mt-4 space-y-2">
            <label class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
              Cities / Tags
            </label>
            <div class="flex flex-wrap gap-x-6 gap-y-2">
              @foreach($cities as $city)
              <div class="flex items-center">
                <input type="checkbox" name="cities[]" value="{{ $city->id }}" id="edit-city-{{ $city->id }}" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500">
                <label for="edit-city-{{ $city->id }}" class="text-sm text-gray-500 ms-2 dark:text-gray-400">{{ $city->nom }}</label>
              </div>
              @endforeach
            </div>
          </div>

          <!-- Photo -->
          <div class="mt-4 space-y-2">
            <label for="edit-photo" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
              Photo
            </label>
            <div id="current-photo-container" class="mb-2 hidden">
                <img id="current-photo-preview" src="" alt="Current Photo" class="h-16 w-16 rounded-full object-cover">
            </div>
            <input id="edit-photo" name="photo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 dark:file:bg-blue-500 dark:hover:file:bg-blue-400">
          </div>

          <!-- Footer -->
          <div class="mt-6 flex justify-end gap-x-2">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800" onclick="closeEditModal()">
              Cancel
            </button>
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
              Update Contact
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function openEditModal(contactId) {
        // Fetch contact data
        fetch(`/admin/contacts/${contactId}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(contact => {
            // Populate Form
            const form = document.getElementById('edit-contact-form');
            form.action = `/admin/contacts/${contactId}`;
            
            document.getElementById('edit-nom').value = contact.nom;
            document.getElementById('edit-prenom').value = contact.prenom;
            document.getElementById('edit-email').value = contact.email;
            document.getElementById('edit-telephone').value = contact.telephone;
            
            // Handle cities
            // Reset all checks
            form.querySelectorAll('input[name="cities[]"]').forEach(el => el.checked = false);
            // Check existing
            if (contact.cities) {
                contact.cities.forEach(city => {
                    const checkbox = document.getElementById(`edit-city-${city.id}`);
                    if (checkbox) checkbox.checked = true;
                });
            }

            // Handle photo preview
            const photoContainer = document.getElementById('current-photo-container');
            const photoPreview = document.getElementById('current-photo-preview');
            if(contact.photo) {
                photoPreview.src = `/storage/${contact.photo}`;
                photoContainer.classList.remove('hidden');
            } else {
                photoContainer.classList.add('hidden');
            }

            // Open Modal (Manual Logic)
            const modal = document.getElementById('edit-contact-modal');
            modal.classList.remove('hidden');
            modal.classList.add('open');
            modal.classList.remove('pointer-events-none');
            
            // Animation state
            const inner = modal.querySelector('.hs-overlay-open\\:mt-7') || modal.firstElementChild;
             if(inner) {
                 inner.classList.remove('opacity-0', 'mt-0');
                 inner.classList.add('opacity-100', 'mt-7');
             }
        })
        .catch(err => {
            console.error('Failed to load contact', err);
            alert('Failed to load contact data.');
        });
    }

    function closeEditModal() {
        const modal = document.getElementById('edit-contact-modal');
        if(modal) {
            modal.classList.add('hidden');
            modal.classList.add('pointer-events-none');
            
            // Reset form
            document.getElementById('edit-contact-form').reset();
            
             // Reset animation
             const inner = modal.querySelector('.mt-7') || modal.firstElementChild;
             if(inner) {
                 inner.classList.add('opacity-0', 'mt-0');
                 inner.classList.remove('opacity-100', 'mt-7');
             }
        }
    }

    // Handle Edit Form Submission via AJAX
    document.addEventListener('DOMContentLoaded', () => {
        const editForm = document.getElementById('edit-contact-form');
        if(editForm) {
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(editForm);
                const submitBtn = editForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerText;
                const isDashboard = formData.get('source') === 'dashboard';

                submitBtn.disabled = true;
                submitBtn.innerText = 'Updating...';
                
                 // Clear previous errors
                // ... (simplified error clearing)

                fetch(editForm.action, {
                    method: 'POST', // Method spoofing is handled by _method input
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status === 200) {
                        closeEditModal();
                         if (isDashboard) {
                            window.location.reload();
                        } else {
                            // Update row
                             // We receive the new row HTML from server (needs Controller update)
                             // Or we just reload for simplicity since updating a row with many columns is complex
                             // Let's reload to be safe, or if body.html exists, replace.
                             if(body.html) {
                                  // extract ID from action URL or response
                                   // Assuming response contains the updated contact object or ID
                                   // Let's assume we reload for now unless we update controller to return HTML
                                   
                                   // To match "Add" experience, let's update controller to return HTML
                                   const rowId = `contact-row-${body.contact.id}`;
                                   const existingRow = document.getElementById(rowId);
                                   if(existingRow) {
                                       existingRow.outerHTML = body.html;
                                   }
                             } else {
                                 window.location.reload();
                             }
                        }
                    } else {
                        alert('Error updating contact');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalText;
                });
            });
        }
    });
</script>
