<script>
const Modal = {
    open(id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.remove('pointer-events-none');
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
        const form = modal.querySelector('form');
        if (form) form.reset();
    }
};

// Modal close buttons
document.querySelectorAll('.modal-close').forEach(btn => {
    btn.addEventListener('click', () => Modal.close(btn.dataset.modal));
});

// Open create modal
document.querySelectorAll('[data-hs-overlay="#create-contact-modal"]').forEach(btn => {
    btn.addEventListener('click', () => Modal.open('create-contact-modal'));
});

// Create form submission
document.getElementById('create-contact-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerText;
    btn.disabled = true;
    btn.innerText = 'Creating...';

    try {
        const res = await fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        
        if (res.status === 422) {
            alert(Object.values(data.errors).flat().join('\n'));
        } else if (data.success) {
            Modal.close('create-contact-modal');
            if (window.location.pathname.includes('dashboard')) {
                window.location.reload();
            } else {
                const tbody = document.querySelector('tbody');
                tbody?.querySelector('td[colspan]')?.closest('tr')?.remove();
                tbody?.insertAdjacentHTML('afterbegin', data.html);
            }
        }
    } catch (err) {
        alert('An error occurred');
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
});

// Edit modal
window.openEditModal = async function(contactId) {
    try {
        const res = await fetch(`/admin/contacts/${contactId}/edit`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const contact = await res.json();
        
        const form = document.getElementById('edit-contact-form');
        form.action = `/admin/contacts/${contactId}`;
        document.getElementById('edit-nom').value = contact.nom;
        document.getElementById('edit-prenom').value = contact.prenom;
        document.getElementById('edit-email').value = contact.email;
        document.getElementById('edit-telephone').value = contact.telephone;
        
        form.querySelectorAll('input[name="cities[]"]').forEach(el => el.checked = false);
        contact.cities?.forEach(city => {
            document.getElementById(`edit-city-${city.id}`)?.setAttribute('checked', true);
        });

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
        alert('Failed to load contact');
    }
};

// Edit form submission
document.getElementById('edit-contact-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerText;
    btn.disabled = true;
    btn.innerText = 'Updating...';

    try {
        const res = await fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        const data = await res.json();
        
        if (res.ok && data.success) {
            Modal.close('edit-contact-modal');
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
        alert('An error occurred');
    } finally {
        btn.disabled = false;
        btn.innerText = originalText;
    }
});

// Delete functionality
let contactIdToDelete = null;

window.deleteContact = function(contactId) {
    contactIdToDelete = contactId;
    Modal.open('delete-contact-modal');
};

document.getElementById('confirm-delete-btn')?.addEventListener('click', async function() {
    if (!contactIdToDelete) return;
    
    this.disabled = true;
    this.innerText = 'Deleting...';

    try {
        const res = await fetch(`/admin/contacts/${contactIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        
        if (data.success) {
            Modal.close('delete-contact-modal');
            if (window.location.pathname.includes('dashboard')) {
                window.location.reload();
            } else {
                document.getElementById(`contact-row-${contactIdToDelete}`)?.remove();
                if (!document.querySelector('tbody tr')) window.location.reload();
            }
        } else {
            alert('Failed to delete');
        }
    } catch (err) {
        alert('An error occurred');
    } finally {
        this.disabled = false;
        this.innerText = 'Confirm';
        contactIdToDelete = null;
    }
});

// City dropdown
const cityDropdown = {
    button: document.getElementById('cityDropdownButton'),
    menu: document.getElementById('cityDropdownMenu'),
    icon: document.getElementById('cityDropdownIcon'),
    text: document.getElementById('cityDropdownText'),
    
    toggle() {
        const isHidden = this.menu.classList.toggle('hidden');
        this.icon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
    },
    
    updateText() {
        const checked = document.querySelectorAll('input[name="cities[]"]:checked');
        if (checked.length === 0) {
            this.text.textContent = 'Select Cities';
            this.text.className = 'text-slate-600';
        } else if (checked.length === 1) {
            this.text.textContent = checked[0].nextElementSibling.textContent;
            this.text.className = 'text-slate-800 font-medium';
        } else {
            this.text.textContent = `${checked.length} cities selected`;
            this.text.className = 'text-slate-800 font-medium';
        }
    }
};

cityDropdown.button?.addEventListener('click', e => { e.preventDefault(); cityDropdown.toggle(); });
document.addEventListener('click', e => {
    if (!cityDropdown.button?.contains(e.target) && !cityDropdown.menu?.contains(e.target)) {
        cityDropdown.menu?.classList.add('hidden');
        if (cityDropdown.icon) cityDropdown.icon.style.transform = 'rotate(0deg)';
    }
});

window.updateCityDropdownText = () => cityDropdown.updateText();
window.clearAllCities = () => {
    document.querySelectorAll('input[name="cities[]"]').forEach(cb => cb.checked = false);
    cityDropdown.updateText();
};

cityDropdown.updateText();
</script>
