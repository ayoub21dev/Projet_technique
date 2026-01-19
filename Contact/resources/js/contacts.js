$(document).ready(function() {
    const $tableBody = $('#contacts-table');
    const $modal = $('#contactModal');
    const $form = $('#contactForm');
    const $searchInput = $('#search');
    const $openModalBtn = $('#openModal');
    const $successMsg = $('#success-msg');

    // Safety check for routes
    if (typeof window.CONTACT_ROUTES === 'undefined') {
        console.error("CONTACT_ROUTES is not defined");
        return;
    }

    // 1. Search with AJAX
    $searchInput.on('input', function() {
        const query = $(this).val();
        
        $.ajax({
            url: window.CONTACT_ROUTES.index,
            type: 'GET',
            data: { query: query },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(html) {
                $tableBody.html(html);
            },
            error: function(xhr, status, error) {
                console.error("Search failed:", error);
            }
        });
    });

    // 2. Open Modal (Add)
    $openModalBtn.on('click', function() {
        $form[0].reset();
        $form.attr('action', window.CONTACT_ROUTES.store);
        
        // Remove hidden method input if it exists (from edit mode)
        $form.find('input[name="_method"]').remove();
        
        // Reset selected cities
        $form.find('option').prop('selected', false);
        
        $modal.removeClass('hidden');
    });

    // 3. Close Modal
    $(document).on('click', '.close-btn', function() {
        $modal.addClass('hidden');
    });

    // 4. Submit Form (Create or Update)
    $form.on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(html) {
                $tableBody.html(html);
                $modal.addClass('hidden');
                $form[0].reset();
                showSuccess("Opération réussie !");
            },
            error: function(xhr, status, error) {
                console.error("Form submit error:", error);
                alert("Erreur: " + xhr.responseText);
            }
        });
    });

    // 5. Delete Contact (Event Delegation)
    $tableBody.on('click', '.delete-btn', function() {
        if (!confirm('Voulez-vous vraiment supprimer ce contact ?')) return;
        
        const id = $(this).data('id');
        const url = window.CONTACT_ROUTES.destroy + '/' + id;
        
        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify({ _method: 'DELETE' }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(html) {
                $tableBody.html(html);
                showSuccess("Contact supprimé.");
            },
            error: function(xhr, status, error) {
                console.error("Delete error:", error);
                alert("Erreur lors de la suppression");
            }
        });
    });

    // 6. Edit Contact (Event Delegation)
    $tableBody.on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const urlData = window.CONTACT_ROUTES.editData + '/' + id + '/edit-data';
        const urlUpdate = window.CONTACT_ROUTES.update + '/' + id;
        
        $.ajax({
            url: urlData,
            type: 'GET',
            dataType: 'json',
            success: function(contact) {
                // Set form action for update
                $form.attr('action', urlUpdate);
                
                // Add hidden _method PUT
                let $methodInput = $form.find('input[name="_method"]');
                if ($methodInput.length === 0) {
                    $form.append('<input type="hidden" name="_method" value="PUT">');
                } else {
                    $methodInput.val('PUT');
                }
                
                // Fill form fields
                $form.find('[name="prenom"]').val(contact.prenom);
                $form.find('[name="nom"]').val(contact.nom);
                $form.find('[name="email"]').val(contact.email);
                $form.find('[name="telephone"]').val(contact.telephone);
                
                // Handle Cities (Multi-select)
                if (contact.cities) {
                    const cityIds = contact.cities.map(c => c.id);
                    $form.find('[name="cities[]"] option').each(function() {
                        $(this).prop('selected', cityIds.includes(parseInt($(this).val())));
                    });
                }
                
                $modal.removeClass('hidden');
            },
            error: function(xhr, status, error) {
                console.error("Edit data error:", error);
                alert("Erreur lors du chargement des données");
            }
        });
    });

    // Helper function to show success message
    function showSuccess(msg) {
        $successMsg.text(msg);
        setTimeout(function() {
            $successMsg.text('');
        }, 3000);
    }
});