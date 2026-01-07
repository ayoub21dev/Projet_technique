<!-- Create Contact Modal -->
<div id="create-contact-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-2xl sm:w-full m-3 sm:mx-auto">
    <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-slate-900 dark:border-gray-700 dark:shadow-slate-700/[.7]">
      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
        <h3 class="font-bold text-gray-800 dark:text-white">
          Add New Contact
        </h3>
        <button type="button" class="flex justify-center items-center w-7 h-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#create-contact-modal">
          <span class="sr-only">Close</span>
          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>

      <!-- Body -->
      <div class="p-4 overflow-y-auto max-h-[70vh]">
        <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data" id="create-contact-form">
          @csrf
          <input type="hidden" name="source" value="{{ request()->routeIs('dashboard') ? 'dashboard' : 'index' }}">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- First Name -->
            <div class="space-y-2">
              <label for="modal-prenom" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                First Name <span class="text-red-500">*</span>
              </label>
              <input id="modal-prenom" name="prenom" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" placeholder="John" required>
            </div>

            <!-- Last Name -->
            <div class="space-y-2">
              <label for="modal-nom" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                Last Name <span class="text-red-500">*</span>
              </label>
              <input id="modal-nom" name="nom" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" placeholder="Doe" required>
            </div>

            <!-- Email -->
            <div class="space-y-2">
              <label for="modal-email" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                Email <span class="text-red-500">*</span>
              </label>
              <input id="modal-email" name="email" type="email" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" placeholder="john@example.com" required>
            </div>

            <!-- Phone -->
            <div class="space-y-2">
              <label for="modal-telephone" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
                Phone <span class="text-red-500">*</span>
              </label>
              <input id="modal-telephone" name="telephone" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" placeholder="0612345678" required>
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
                <input type="checkbox" name="cities[]" value="{{ $city->id }}" id="modal-city-{{ $city->id }}" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500">
                <label for="modal-city-{{ $city->id }}" class="text-sm text-gray-500 ms-2 dark:text-gray-400">{{ $city->nom }}</label>
              </div>
              @endforeach
            </div>
          </div>

          <!-- Photo -->
          <div class="mt-4 space-y-2">
            <label for="modal-photo" class="inline-block text-sm font-medium text-gray-800 dark:text-gray-200">
              Photo
            </label>
            <input id="modal-photo" name="photo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 dark:file:bg-blue-500 dark:hover:file:bg-blue-400">
          </div>

          <!-- Footer -->
          <div class="mt-6 flex justify-end gap-x-2">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800" data-hs-overlay="#create-contact-modal">
              Cancel
            </button>
            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
              Create Contact
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Create Contact Modal -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('create-contact-form');
    // If form doesn't exist (e.g. partial not loaded), do nothing
    if(!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerText;
        const isDashboard = formData.get('source') === 'dashboard';
        
        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.innerText = 'Creating...';
        
        // Clear previous errors
        document.querySelectorAll('.error-feedback').forEach(el => el.remove());
        document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            if (status === 422) {
                // Validation Errors
                Object.keys(body.errors).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        input.classList.add('border-red-500');
                        // Handle array inputs like cities[]
                        const errorContainer = key === 'cities' ? input.closest('.flex-wrap').parentElement : input.parentElement;
                        
                        const errorMsg = document.createElement('p');
                        errorMsg.className = 'text-xs text-red-600 mt-2 error-feedback';
                        errorMsg.innerText = body.errors[key][0];
                        errorContainer.appendChild(errorMsg);
                    }
                });
            } else if (body.success) {
                // Happy Path
                
                // Close modal
                const closeBtn = document.querySelector('[data-hs-overlay="#create-contact-modal"]');
                if(closeBtn) closeBtn.click();
                
                // Reset form
                form.reset();
                
                if (isDashboard) {
                    // On Dashboard: Reload to update stats and list
                    // Or we could show a toast. Reload is safest for sync.
                    window.location.reload();
                } else {
                    // On Contacts Index: Append new row
                    const tbody = document.querySelector('tbody');
                    if (tbody) {
                        const emptyRow = tbody.querySelector('tr td[colspan]');
                        if (emptyRow) {
                            emptyRow.closest('tr').remove();
                        }
                        
                        // Create a template to insert HTML
                        const template = document.createElement('template');
                        template.innerHTML = body.html.trim();
                        tbody.prepend(template.content.firstChild);
                    }
                }
                
            } else {
                alert('Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
        })
        .finally(() => {
            if(submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = originalBtnText;
            }
        });
    });
});
</script>

<script>
    // Fallback Manual Modal Handling to ensure visibility
    function openCreateModal() {
        const modal = document.getElementById('create-contact-modal');
        if(modal) {
            // Force visibility by ensuring hidden is removed and open is added
            modal.classList.remove('hidden');
            modal.classList.add('open');
            modal.classList.remove('pointer-events-none');
            
            // Fix visibility of inner content which depends on Preline animation
            const inner = modal.querySelector('.hs-overlay-open\\:mt-7');
             // The class selector might require escaping or partial match. 
             // Let's use a broader selector for the inner container:
            const innerContainer = modal.firstElementChild;
            if(innerContainer) {
                 // Force the state that Preline would apply
                 innerContainer.classList.remove('opacity-0', 'mt-0');
                 innerContainer.classList.add('opacity-100', 'mt-7');
            }
        }
    }

    function closeCreateModal() {
        const modal = document.getElementById('create-contact-modal');
        if(modal) {
            modal.classList.add('hidden');
            modal.classList.add('pointer-events-none');
            
             // Reset inner state for next animation (optional, but good for consistency)
            const innerContainer = modal.firstElementChild;
            if(innerContainer) {
                 innerContainer.classList.add('opacity-0', 'mt-0');
                 innerContainer.classList.remove('opacity-100', 'mt-7');
            }
        }
    }

    // Attach listeners to buttons manually to bypass library
    document.addEventListener('DOMContentLoaded', function() {
        const openBtns = document.querySelectorAll('[data-hs-overlay="#create-contact-modal"]');
        openBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
               // We don't preventDefault here because the button might not be a submit button,
               // but it's safer to just run our logic.
               const modal = document.getElementById('create-contact-modal');
               // If modal is still hidden or we just want to force it
               openCreateModal();
            });
        });

        // Close buttons inside the modal
        const modal = document.getElementById('create-contact-modal');
        if(modal) {
             const internalClose = modal.querySelectorAll('[data-hs-overlay="#create-contact-modal"]');
             internalClose.forEach(btn => {
                 btn.addEventListener('click', closeCreateModal);
             });
        }
    });
</script>
