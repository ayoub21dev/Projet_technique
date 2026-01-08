<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactService
{
    /**
     * Retrieve all contacts for the current user, or all contacts if the user is an admin.
     * Results are ordered by name (nom).
     */
    public function getAll()
    {
        return $this->baseQuery()->orderBy('nom')->get();
    }

    /**
     * Create a new contact, associate it with the current user,
     * handle photo upload, and sync city relationships.
     */
    public function create(array $data)
    {
        $data['user_id'] = Auth::id();
        $data = $this->handlePhoto($data);
        $contact = Contact::create($data);
        $this->syncCities($contact, $data);
        return $contact;
    }

    /**
     * Update an existing contact's details, update its photo if provided,
     * and re-sync city relationships.
     */
    public function update(Contact $contact, array $data)
    {
        $data = $this->handlePhoto($data, $contact);
        $contact->update($data);
        $this->syncCities($contact, $data);
        return $contact;
    }

    /**
     * Delete a contact and its associated photo file from storage.
     */
    public function delete(Contact $contact)
    {
        if ($contact->photo) {
            Storage::disk('public')->delete($contact->photo);
        }
        return $contact->delete();
    }

    /**
     * Search and filter contacts based on selected cities and/or a search string.
     * The search string checks name, email, and phone fields.
     */
    public function filterByCity(array $cityIds = [], ?string $searchTerm = null)
    {
        $query = $this->baseQuery();
        
        if (!empty($cityIds)) {
            $query->whereHas('cities', fn($q) => $q->whereIn('cities.id', $cityIds));
        }
        
        if ($searchTerm) {
            $query->where(fn($q) => $q
                ->where('nom', 'like', "%{$searchTerm}%")
                ->orWhere('prenom', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->orWhere('telephone', 'like', "%{$searchTerm}%")
            );
        }
        
        return $query->orderBy('nom')->get();
    }

    /**
     * Define the base query for contacts, including relationships and 
     * restricting access based on user role (admins see everything, users see only theirs).
     */
    private function baseQuery()
    {
        $query = Contact::with('cities', 'user');
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        return $query;
    }

    /**
     * Process an uploaded photo: delete the old one if it exists and store the new one.
     */
    private function handlePhoto(array $data, ?Contact $contact = null): array
    {
        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            if ($contact?->photo) {
                Storage::disk('public')->delete($contact->photo);
            }
            $data['photo'] = $data['photo']->store('contacts', 'public');
        }
        return $data;
    }

    /**
     * Synchronize the many-to-many relationship between the contact and cities.
     */
    private function syncCities(Contact $contact, array $data): void
    {
        if (isset($data['cities'])) {
            $contact->cities()->sync($data['cities']);
        }
    }
}
