<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\City;
use App\Services\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService) {}

    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $cityFilter = (array) $request->input('cities', []);
        
        $contacts = ($search || $cityFilter) 
            ? $this->contactService->filterByCity($cityFilter, $search)
            : $this->contactService->getAll();
        
        return view('admin.contacts.index', [
            'contacts' => $contacts,
            'cities' => City::all(),
            'search' => $search,
            'cityFilter' => $cityFilter
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateContact($request);
        $contact = $this->contactService->create($data);

        if ($request->ajax()) {
            $contact->load('cities', 'user');
            return response()->json([
                'success' => true,
                'html' => view('admin.contacts.row', compact('contact'))->render()
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact created.');
    }

    public function edit(Contact $contact)
    {
        $this->authorizeContact($contact);
        
        if (request()->wantsJson()) {
            return response()->json($contact->load('cities'));
        }

        return view('admin.contacts.index', [
            'contact' => $contact,
            'cities' => City::all()
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorizeContact($contact);
        $data = $this->validateContact($request);
        $this->contactService->update($contact, $data);

        if ($request->ajax()) {
            $contact->refresh()->load('cities', 'user');
            return response()->json([
                'success' => true,
                'contact' => $contact,
                'html' => view('admin.contacts.row', compact('contact'))->render()
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        $this->authorizeContact($contact);
        $this->contactService->delete($contact);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact deleted.');
    }

    private function validateContact(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'cities' => 'nullable|array',
            'cities.*' => 'exists:cities,id',
        ]);
    }

    private function authorizeContact(Contact $contact): void
    {
        if (auth()->user()->role !== 'admin' && $contact->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
