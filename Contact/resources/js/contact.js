const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.content;

const registerContactsManager = () => {
    const Alpine = window.Alpine;
    if (!Alpine || window.__contactsManagerRegistered) return;

    Alpine.data('contactsManager', () => ({
        successMessage: '',
        searchQuery: '',
        selectedCities: [],
        cityDropdownOpen: false,
        showCreateModal: false,
        showEditModal: false,
        showDeleteModal: false,
        contactIdToDelete: null,
        createSubmitting: false,
        editSubmitting: false,
        deleteSubmitting: false,

        init() {
            this.searchQuery = this.$refs.searchInput?.value || '';
            this.selectedCities = Array.from(this.$el.querySelectorAll('.filter-city-checkbox:checked')).map((el) => Number(el.value));

            this.$el.addEventListener('click', (event) => {
                const link = event.target.closest('#pagination-container a');
                if (!link) return;
                event.preventDefault();
                this.fetchContacts(link.href);
            });

            window.openEditModal = (contactId) => this.openEditModal(contactId);
            window.deleteContact = (contactId) => this.confirmDelete(contactId);
            window.clearAllCities = () => this.clearCities();
        },

        showSuccess(message) {
            this.successMessage = message;
            setTimeout(() => {
                this.successMessage = '';
            }, 3000);
        },

        cityText() {
            if (this.selectedCities.length === 0) return 'All Cities';
            if (this.selectedCities.length === 1) {
                const checked = this.$el.querySelector('.filter-city-checkbox:checked + span');
                return checked?.textContent?.trim() || '1 City';
            }

            return `${this.selectedCities.length} Cities`;
        },

        async fetchContacts(url = null) {
            if (!url) {
                const params = new URLSearchParams();
                if (this.searchQuery) params.set('search', this.searchQuery);
                this.selectedCities.forEach((cityId) => params.append('cities[]', cityId));
                url = `${window.location.pathname}${params.toString() ? `?${params.toString()}` : ''}`;
            }

            try {
                this.$refs.contactsTableBody.style.opacity = '0.5';
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    },
                });

                const data = await response.json();
                if (data.html) {
                    this.$refs.contactsTableBody.innerHTML = data.html;
                    Alpine.initTree(this.$refs.contactsTableBody);
                }

                if (data.pagination && this.$refs.paginationContainer) {
                    this.$refs.paginationContainer.innerHTML = data.pagination;
                    Alpine.initTree(this.$refs.paginationContainer);
                }
            } catch (error) {
                console.error('Failed to fetch contacts', error);
            } finally {
                this.$refs.contactsTableBody.style.opacity = '1';
            }
        },

        toggleCity(cityId, checked) {
            const numericId = Number(cityId);
            if (checked && !this.selectedCities.includes(numericId)) {
                this.selectedCities.push(numericId);
            }

            if (!checked) {
                this.selectedCities = this.selectedCities.filter((id) => id !== numericId);
            }

            this.fetchContacts();
        },

        clearCities() {
            this.selectedCities = [];
            this.$el.querySelectorAll('.filter-city-checkbox').forEach((checkbox) => {
                checkbox.checked = false;
            });
            this.fetchContacts();
        },

        openCreateModal() { this.showCreateModal = true; },
        closeCreateModal() { this.showCreateModal = false; this.$refs.createForm?.reset(); },

        async submitCreateContact() {
            this.createSubmitting = true;
            try {
                const response = await fetch(this.$refs.createForm.action, {
                    method: 'POST',
                    body: new FormData(this.$refs.createForm),
                    headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    this.closeCreateModal();
                    this.showSuccess('Contact created successfully!');
                    this.fetchContacts();
                }
            } finally {
                this.createSubmitting = false;
            }
        },

        async openEditModal(contactId) {
            const response = await fetch(`/admin/contacts/${contactId}/edit`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            });

            const contact = await response.json();
            this.$refs.editForm.action = `/admin/contacts/${contactId}`;
            this.$refs.editForm.querySelector('#edit-nom').value = contact.nom;
            this.$refs.editForm.querySelector('#edit-prenom').value = contact.prenom;
            this.$refs.editForm.querySelector('#edit-email').value = contact.email;
            this.$refs.editForm.querySelector('#edit-telephone').value = contact.telephone;
            this.$refs.editForm.querySelectorAll('input[name="cities[]"]').forEach((el) => { el.checked = false; });
            contact.cities?.forEach((city) => {
                const checkbox = this.$refs.editForm.querySelector(`#edit-city-${city.id}`);
                if (checkbox) checkbox.checked = true;
            });

            if (contact.photo) {
                this.$refs.currentPhotoPreview.src = `/storage/${contact.photo}`;
                this.$refs.currentPhotoContainer.classList.remove('hidden');
            } else {
                this.$refs.currentPhotoContainer.classList.add('hidden');
            }

            this.showEditModal = true;
        },

        closeEditModal() { this.showEditModal = false; this.$refs.editForm?.reset(); },

        async submitEditContact() {
            this.editSubmitting = true;
            try {
                const response = await fetch(this.$refs.editForm.action, {
                    method: 'POST',
                    body: new FormData(this.$refs.editForm),
                    headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    this.closeEditModal();
                    this.showSuccess('Contact updated successfully!');
                    this.fetchContacts();
                }
            } finally {
                this.editSubmitting = false;
            }
        },

        confirmDelete(contactId) { this.contactIdToDelete = contactId; this.showDeleteModal = true; },
        closeDeleteModal() { this.contactIdToDelete = null; this.showDeleteModal = false; },

        async submitDeleteContact() {
            if (!this.contactIdToDelete) return;
            this.deleteSubmitting = true;

            try {
                const response = await fetch(`/admin/contacts/${this.contactIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    },
                });

                const data = await response.json();
                if (response.ok && data.success) {
                    this.closeDeleteModal();
                    this.showSuccess('Contact deleted successfully!');
                    this.fetchContacts();
                }
            } finally {
                this.deleteSubmitting = false;
            }
        },
    }));

    window.__contactsManagerRegistered = true;
};

if (window.Alpine) {
    registerContactsManager();
} else {
    document.addEventListener('alpine:init', registerContactsManager, { once: true });
}
