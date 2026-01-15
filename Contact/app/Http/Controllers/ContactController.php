<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\City;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
        $contacts = $this->contactService->getAll();
        $cities = City::all();
        return view('contacts.index', compact('contacts', 'cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'cities' => 'nullable|array',
            'cities.*' => 'exists:cities,id',
        ]);

        $contact = $this->contactService->create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contact créé avec succès !',
                'contact' => $contact
            ]);
        }

        return redirect()->back()->with('success', 'Contact créé avec succès !');
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'cities' => 'nullable|array',
            'cities.*' => 'exists:cities,id',
        ]);

        $this->contactService->update($contact, $validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Contact mis à jour avec succès !'
            ]);
        }

        return redirect()->back()->with('success', 'Contact mis à jour avec succès !');
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->delete($contact);

        return response()->json([
            'success' => true,
            'message' => 'Contact supprimé avec succès !'
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->query('query');
        $contacts = $this->contactService->filterByCity([], $searchTerm);

        if ($request->ajax()) {
            return view('contacts._table_body', compact('contacts'))->render();
        }

        return view('contacts.index', compact('contacts'));
    }
}
