<script>
    let contactIdToDelete = null;

    // Open the modal
    window.deleteContact = function(contactId) {
        console.log('Preparing to delete contact:', contactId);
        contactIdToDelete = contactId;
        
        const modalEl = document.querySelector('#delete-contact-modal');
        if (typeof HSOverlay !== 'undefined') {
            try {
                HSOverlay.open(modalEl);
            } catch (e) {
                console.warn('HSOverlay error, using fallback', e);
                modalEl.classList.remove('hidden');
                modalEl.classList.add('flex'); // Ensure it displays
                modalEl.classList.remove('pointer-events-none'); // Enable clicking
                modalEl.classList.add('pointer-events-auto');
            }
        } else {
            // Fallback if Preline JS isn't fully loaded/initialized yet
            modalEl.classList.remove('hidden');
             modalEl.classList.add('flex'); // Ensure it displays
             modalEl.classList.remove('pointer-events-none'); // Enable clicking
             modalEl.classList.add('pointer-events-auto');
        }
    };

    // Handle actual deletion
    document.getElementById('confirm-delete-btn').addEventListener('click', function() {
        if (!contactIdToDelete) return;
        
        const contactId = contactIdToDelete;
        const btn = this;
        
        // Disable button and show loading state
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-[3px] border-current border-t-transparent text-white rounded-full" role="status" aria-label="loading"></span> Deleting...';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const isDashboard = window.location.pathname.includes('dashboard');

        fetch(`/admin/contacts/${contactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            return response.text().then(text => { throw new Error(text || 'Network response was not ok') });
        })
        .then(data => {
            if (data.success) {
                // Close modal
                const modalEl = document.querySelector('#delete-contact-modal');
                if (typeof HSOverlay !== 'undefined') {
                    try {
                        HSOverlay.close(modalEl);
                    } catch (e) {
                         modalEl.classList.add('hidden');
                         modalEl.classList.remove('flex');
                    }
                } else {
                    modalEl.classList.add('hidden');
                    modalEl.classList.remove('flex');
                }

                if(isDashboard) {
                    window.location.reload();
                } else {
                    const row = document.getElementById(`contact-row-${contactId}`);
                    if(row) {
                        row.remove();
                        // Check if table is empty
                        const tbody = document.querySelector('tbody');
                        if (tbody && tbody.children.length === 0) {
                            window.location.reload(); 
                        }
                    } else {
                        window.location.reload();
                    }
                }
            } else {
                alert('Failed to delete contact: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Delete operation error:', error);
            alert('An error occurred while deleting: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            btn.disabled = false;
            btn.innerHTML = 'Confirm';
            contactIdToDelete = null;
        });
    });
</script>
