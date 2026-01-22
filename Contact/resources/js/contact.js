
/**
 * Contact Management AJAX Logic
 */

// Utility for CSRF Token
const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.content;

// Modal Logic
const Modal = {
    open(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.remove('pointer-events-none');
        // Handle transition if inner exists
        const inner = modal.firstElementChild;
        if (inner) {
            inner.classList.remove('opacity-0', 'mt-0');
            inner.classList.add('opacity-100', 'mt-7');
        }
    },
    close(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden', 'pointer-events-none');
        const inner = modal.firstElementChild;
        if (inner) {
            inner.classList.add('opacity-0', 'mt-0');
            inner.classList.remove('opacity-100', 'mt-7');
        }
        // Reset forms inside if any
        const form = modal.querySelector('form');
        if (form) form.reset();
    }
};

// Expose Modal to window if needed or just use internal
window.closeModal = (id) => Modal.close(id);

// Success Message Helper
const showSuccess = (msg) => {
    const el = document.getElementById('success-msg');
    if (el) {
        el.innerText = msg;
        setTimeout(() => el.innerText = '', 3000);
    }
};

// --- Event Listeners & Logic ---

document.addEventListener('DOMContentLoaded', () => {
    
    // Close buttons
    document.querySelectorAll('.modal-close').forEach(btn => {
        btn.addEventListener('click', () => Modal.close(btn.dataset.modal));
    });

    // Open create modal
    document.querySelectorAll('[data-hs-overlay="#create-contact-modal"]').forEach(btn => {
        btn.addEventListener('click', () => Modal.open('create-contact-modal'));
    });

    // SEARCH & FILTER
    const searchInput = document.getElementById('search-input');
    const contactsTableBody = document.getElementById('contacts-table-body');
    
    // Function to fetch contacts
    const fetchContacts = (url = null) => {
        const searchInput = document.getElementById('search-input');
        const contactsTableBody = document.getElementById('contacts-table-body');
        const paginationContainer = document.getElementById('pagination-container');

        if (!url) {
            const query = searchInput?.value || '';
            const checkedCities = Array.from(document.querySelectorAll('.filter-city-checkbox:checked'))
                .map(cb => `cities[]=${cb.value}`)
                .join('&');
            url = `${window.location.pathname}?search=${encodeURIComponent(query)}${checkedCities ? '&' + checkedCities : ''}`;
        }
        
        // Show loading state
        if (contactsTableBody) contactsTableBody.style.opacity = '0.5';

        fetch(url, {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const contentType = response.headers.get("content-type");
            const responseText = await response.text();
            
            // Try to parse as JSON first
            if (contentType && contentType.includes("application/json")) {
                try {
                    return JSON.parse(responseText);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    return { html: responseText };
                }
            }
            
            // If response looks like JSON, try to parse it
            if (responseText.trim().startsWith('{')) {
                try {
                    return JSON.parse(responseText);
                } catch (e) {
                    // Not valid JSON, treat as HTML
                    return { html: responseText };
                }
            }
            
            // Plain HTML response
            return { html: responseText };
        })
        .then(data => {
            if (contactsTableBody && data.html) {
                // Safely insert the HTML content
                contactsTableBody.innerHTML = data.html;
                contactsTableBody.style.opacity = '1';
            }
            if (paginationContainer && data.pagination) {
                paginationContainer.innerHTML = data.pagination;
            }
        })
        .catch(err => {
            console.error('Error fetching contacts:', err);
            if (contactsTableBody) contactsTableBody.style.opacity = '1';
        });
    };

    // Pagination Click Handling (Event Delegation)
    document.addEventListener('click', (e) => {
        const link = e.target.closest('#pagination-container a');
        if (link) {
            e.preventDefault();
            fetchContacts(link.href);
            // Smooth scroll to results
            document.getElementById('search-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // Debounce search
    let debounceTimer;
    searchInput?.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchContacts, 300);
    });

    const searchForm = document.getElementById('search-form');
    searchForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchContacts();
    });

    // Filter Trigger for Cities
    document.querySelectorAll('.filter-city-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
            cityDropdown.updateText();
            fetchContacts();
        });
    });


    // CREATE CONTACT
    const createForm = document.getElementById('create-contact-form');
    createForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Creating...';

        try {
            const res = await fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest', 
                    'Accept': 'application/json' 
                }
            });
            const data = await res.json();
            
            if (res.status === 422) {
                alert('Validation Error:\n' + Object.values(data.errors).flat().join('\n'));
            } else if (data.success) {
                Modal.close('create-contact-modal');
                showSuccess('Contact created successfully!');
                // Check if we are on dashboard or admin list. 
                // Admin controller returns HTML row. Dashboard might behave differently.
                // For now, assuming Admin Index view structure.
                if (data.html && contactsTableBody) {
                    // Remove "No contacts found" row if it exists
                    const noContactsRow = contactsTableBody.querySelector('td[colspan]')?.closest('tr');
                    if (noContactsRow) noContactsRow.remove();
                    
                    contactsTableBody.insertAdjacentHTML('afterbegin', data.html);
                } else {
                    window.location.reload();
                }
            } else {
                alert('Something went wrong.');
            }
        } catch (err) {
            console.error(err);
            alert('An error occurred.');
        } finally {
            btn.disabled = false;
            btn.innerText = originalText;
        }
    });

    // EDIT CONTACT
    const editForm = document.getElementById('edit-contact-form');
    editForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Updating...';

        try {
            const res = await fetch(this.action, {
                method: 'POST', // Method spoofing usually handled by _method input
                body: new FormData(this),
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest', 
                    'Accept': 'application/json' 
                }
            });
            const data = await res.json();
            
            if (res.ok && data.success) {
                Modal.close('edit-contact-modal');
                showSuccess('Contact updated successfully!');
                if (data.html) {
                    const row = document.getElementById(`contact-row-${data.contact.id}`);
                    if (row) row.outerHTML = data.html;
                } else {
                    window.location.reload();
                }
            } else {
                alert('Error updating contact');
            }
        } catch (err) {
            console.error(err);
            alert('An error occurred while updating.');
        } finally {
            btn.disabled = false;
            btn.innerText = originalText;
        }
    });

    // DELETE CONTACT
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    confirmDeleteBtn?.addEventListener('click', async function() {
        if (!window.contactIdToDelete) return;
        
        this.disabled = true;
        this.innerText = 'Deleting...';

        try {
            const res = await fetch(`/admin/contacts/${window.contactIdToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();
            
            if (data.success) {
                Modal.close('delete-contact-modal');
                showSuccess('Contact deleted successfully!');
                const row = document.getElementById(`contact-row-${window.contactIdToDelete}`);
                if (row) row.remove();
                
                // If table empty, reload or show empty message (simplest is reload or ignore)
                if (contactsTableBody && contactsTableBody.children.length === 0) {
                     window.location.reload();
                }
            } else {
                alert('Failed to delete.');
            }
        } catch (err) {
            console.error(err);
            alert('An error occurred.');
        } finally {
            this.disabled = false;
            this.innerText = 'Confirm';
            window.contactIdToDelete = null;
        }
    });
});

// --- GLOBAL FUNCTIONS (called by inline HTML) ---

window.openEditModal = async function(contactId) {
    try {
        const res = await fetch(`/admin/contacts/${contactId}/edit`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const contact = await res.json();
        
        const form = document.getElementById('edit-contact-form');
        form.action = `/admin/contacts/${contactId}`;
        
        // Populate fields
        if(form.querySelector('#edit-nom')) form.querySelector('#edit-nom').value = contact.nom;
        if(form.querySelector('#edit-prenom')) form.querySelector('#edit-prenom').value = contact.prenom;
        if(form.querySelector('#edit-email')) form.querySelector('#edit-email').value = contact.email;
        if(form.querySelector('#edit-telephone')) form.querySelector('#edit-telephone').value = contact.telephone;
        
        // Reset checkboxes
        form.querySelectorAll('input[name="cities[]"]').forEach(el => el.checked = false);
        // Check owned cities
        contact.cities?.forEach(city => {
            const cb = document.getElementById(`edit-city-${city.id}`);
            if (cb) cb.checked = true;
        });

        // Photo
        const photoContainer = document.getElementById('current-photo-container');
        const photoPreview = document.getElementById('current-photo-preview');
        if (contact.photo) {
            photoPreview.src = `/storage/${contact.photo}`;
            photoContainer.classList.remove('hidden');
        } else {
            photoContainer.classList.add('hidden');
        }

        Modal.open('edit-contact-modal');
    } catch (err) {
        console.error(err);
        alert('Failed to load contact details.');
    }
};

window.deleteContact = function(contactId) {
    window.contactIdToDelete = contactId;
    Modal.open('delete-contact-modal');
};

// City Dropdown Globals
const cityDropdown = {
    button: document.getElementById('cityDropdownButton'),
    menu: document.getElementById('cityDropdownMenu'),
    icon: document.getElementById('cityDropdownIcon'),
    text: document.getElementById('cityDropdownText'),
    
    toggle() {
        if (!this.menu) return;
        const isHidden = this.menu.classList.toggle('hidden');
        if (this.icon) this.icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
    },
    
    updateText() {
        if (!this.text) return;
        const checked = document.querySelectorAll('.filter-city-checkbox:checked');
        if (checked.length === 0) {
            this.text.textContent = 'All Cities';
            this.text.className = 'text-slate-600 truncate';
        } else if (checked.length === 1) {
            this.text.textContent = checked[0].nextElementSibling.textContent;
            this.text.className = 'text-blue-600 font-semibold truncate';
        } else {
            this.text.textContent = `${checked.length} Cities`;
            this.text.className = 'text-blue-600 font-semibold truncate';
        }
    }
};

// Re-attach listener if DOM element exists (for the button itself)
document.addEventListener('DOMContentLoaded', () => {
    // Re-bind elements in case they weren't ready
    cityDropdown.button = document.getElementById('cityDropdownButton');
    cityDropdown.menu = document.getElementById('cityDropdownMenu');
    cityDropdown.icon = document.getElementById('cityDropdownIcon');
    cityDropdown.text = document.getElementById('cityDropdownText');

    cityDropdown.button?.addEventListener('click', e => { 
        e.preventDefault(); 
        cityDropdown.toggle(); 
    });

    document.addEventListener('click', e => {
        if (cityDropdown.menu && !cityDropdown.menu.classList.contains('hidden')) {
            if (!cityDropdown.button?.contains(e.target) && !cityDropdown.menu?.contains(e.target)) {
                cityDropdown.menu.classList.add('hidden');
                if (cityDropdown.icon) cityDropdown.icon.style.transform = 'rotate(0deg)';
            }
        }
    });
    
    // Initial text update
    cityDropdown.updateText();
});

window.updateCityDropdownText = () => cityDropdown.updateText();
window.clearAllCities = () => {
    document.querySelectorAll('.filter-city-checkbox').forEach(cb => cb.checked = false);
    cityDropdown.updateText();
    // Also trigger fetch to clear filter
    const searchInput = document.getElementById('search-input');
    const event = new Event('input');
    // Or just manually call fetch logic if we exposed it, but triggering change on a checkbox or search input is easier if we wired it up.
    // Actually, checking standard implementation:
    // We added 'change' listener to checkboxes in DOMContentLoaded.
    // Changing 'checked' prop via JS does NOT trigger 'change' event automatically.
    // So we must manually trigger filtering.
    // Let's just create a new 'change' event and dispatch it on one of them or call a global fetch if we had one.
    // Simplest: just trigger a custom event or click the search button ? 
    // Wait, the "Clear All" button calls this.
    // Let's make sure we trigger the filter refresh.
    
    // Re-trigger fetch
    // Since fetchContacts is inside DOMContentLoaded scope, we can't call it directly.
    // We can dispatch an event on the search input.
    const container = document.getElementById('search-input');
    if (container) {
         // Trigger input event to refresh
         container.dispatchEvent(new Event('input'));
    }
};