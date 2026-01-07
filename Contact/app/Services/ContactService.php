<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactService
{
    /**
     * Get all contacts for the authenticated user (or all contacts if admin).
     */
    public function getAll()
    {
        $query = Contact::with('cities', 'user');
        
        // If not admin, only show user's own contacts
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        
        return $query->orderBy('nom')->get();
    }

    /**
     * Create a new contact and sync cities.
     */
    public function create(array $data)
    {
        $data['user_id'] = Auth::id();

        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            $data['photo'] = $data['photo']->store('contacts', 'public');
        }

        $contact = Contact::create($data);

        if (isset($data['cities'])) {
            $contact->cities()->sync($data['cities']);
        }

        return $contact;
    }

    /**
     * Update an existing contact.
     */
    public function update(Contact $contact, array $data)
    {
        if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old photo if exists
            if ($contact->photo) {
                Storage::disk('public')->delete($contact->photo);
            }
            $data['photo'] = $data['photo']->store('contacts', 'public');
        }

        $contact->update($data);

        if (isset($data['cities'])) {
            $contact->cities()->sync($data['cities']);
        }

        return $contact;
    }

    /**
     * Delete a contact and its associated photo.
     */
    public function delete(Contact $contact)
    {
        if ($contact->photo) {
            Storage::disk('public')->delete($contact->photo);
        }
        
        return $contact->delete();
    }

    /**
     * Find a contact by ID (ensuring it belongs to the user, unless admin).
     */
    public function getById($id)
    {
        $query = Contact::with('cities', 'user');
        
        // If not admin, only allow access to user's own contacts
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        
        return $query->findOrFail($id);
    }

    /**
     * Search contacts by name, email, or telephone.
     */
    public function search($term)
    {
        $query = Contact::with('cities', 'user');
        
        // If not admin, only search user's own contacts
        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }
        
        return $query->where(function ($q) use ($term) {
                $q->where('nom', 'like', "%{$term}%")
                    ->orWhere('prenom', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('telephone', 'like', "%{$term}%");
            })
            ->get();
    }
}
