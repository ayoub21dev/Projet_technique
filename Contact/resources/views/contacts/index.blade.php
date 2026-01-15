@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Contacts</h1>
            <p class="text-sm text-gray-500">Liste exhaustive de vos contacts professionnels et personnels.</p>
        </div>
        <div id="success-msg" class="text-green-600 font-medium h-6">
            {{ session('success') }}
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-gray-100">
        <div class="max-w-sm w-full relative">
            <input type="text" id="search" class="py-2.5 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Rechercher un contact...">
            <div id="search-spinner" class="hidden absolute right-3 top-3">
                <div class="animate-spin inline-block w-4 h-4 border-[2px] border-current border-t-transparent text-blue-600 rounded-full" role="status" aria-label="loading"></div>
            </div>
        </div>
        
        <button type="button" id="openModal" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Ajouter un Contact
        </button>
    </div>

    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="border border-gray-200 rounded-lg shadow-sm overflow-hidden bg-white">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Photo</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom & Prénom</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Téléphone</th>
                                <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-500 uppercase tracking-wider">Villes</th>
                                <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="contacts-table" class="divide-y divide-gray-200">
                            @include('contacts._table_body', ['contacts' => $contacts])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('contacts._modal')

@push('scripts')
<script>
$(document).ready(function() {
    const modal = $('#contactModal');
    const form = $('#contactForm');
    
    // CSRF for AJAX
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Open/Close Modal
    $('#openModal').click(() => {
        form[0].reset();
        $('#modalTitle').text('Ajouter un Contact');
        $('#methodField').empty();
        modal.removeClass('hidden');
    });
    $('#closeModal, #cancelBtn').click(() => modal.addClass('hidden'));

    // AJAX Search
    $('#search').on('input', function() {
        let query = $(this).val();
        $('#search-spinner').removeClass('hidden');
        $.get("{{ route('contacts.search') }}", { query: query }, function(data) {
            $('#contacts-table').html(data);
            $('#search-spinner').addClass('hidden');
        });
    });

    // AJAX Store/Update
    form.submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let url = form.attr('action') || "{{ route('contacts.store') }}";

        $.ajax({
            url: url,
            type: "POST", // Method spoofing via _method in form
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                modal.addClass('hidden');
                $('#success-msg').text(response.message);
                $('#search').trigger('input'); // Refresh table
                setTimeout(() => $('#success-msg').text(''), 3000);
            },
            error: function(xhr) {
                alert('Erreur: ' + Object.values(xhr.responseJSON.errors).flat().join('\n'));
            }
        });
    });

    // AJAX Delete
    $(document).on('click', '.delete-btn', function() {
        if(confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `/contacts/${id}`,
                type: "DELETE",
                success: function(response) {
                    $('#search').trigger('input'); // Refresh table
                    $('#success-msg').text(response.message);
                    setTimeout(() => $('#success-msg').text(''), 3000);
                }
            });
        }
    });

    // AJAX Edit (Open Modal and Fill Data)
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        let nom = $(this).data('nom');
        let prenom = $(this).data('prenom');
        let email = $(this).data('email');
        let telephone = $(this).data('telephone');

        $('#modalTitle').text('Modifier le Contact');
        form.attr('action', `/contacts/${id}`);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
        
        $('input[name="nom"]').val(nom);
        $('input[name="prenom"]').val(prenom);
        $('input[name="email"]').val(email);
        $('input[name="telephone"]').val(telephone);

        // Reset and Set Cities
        let cityIds = $(this).data('cities'); // This is an array
        $('select[name="cities[]"]').val(cityIds);

        modal.removeClass('hidden');
    });
});
</script>
@endpush
@endsection
