<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\City;
use App\Services\ContactService;
use Illuminate\Http\Request;

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
        return view('admin.contacts.index', compact('contacts', 'cities'));
    }

    public function create()
    {
        $cities = City::all();
        return view('admin.contacts.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'cities' => 'nullable|array',
            'cities.*' => 'exists:cities,id',
        ]);

        $contact = $this->contactService->create($data);

        if ($request->ajax() || $request->wantsJson()) {
            // Need to load relationships for display
            $contact->load('cities', 'user');
            
            return response()->json([
                'success' => true,
                'message' => 'Contact created successfully.',
                'html' => view('admin.contacts.row', compact('contact'))->render()
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function edit(Contact $contact)
    {
        // Security check: non-admin users can only edit their own contacts
        if (auth()->user()->role !== 'admin' && $contact->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->wantsJson()) {
            return response()->json($contact->load('cities'));
        }

        $cities = City::all();
        return view('admin.contacts.edit', compact('contact', 'cities'));
    }

    public function update(Request $request, Contact $contact)
    {
        // Security check: non-admin users can only update their own contacts
        if (auth()->user()->role !== 'admin' && $contact->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'cities' => 'nullable|array',
            'cities.*' => 'exists:cities,id',
        ]);

        $this->contactService->update($contact, $data);

        if ($request->ajax() || $request->wantsJson()) {
             $contact->refresh()->load('cities', 'user');
             return response()->json([
                 'success' => true,
                 'contact' => $contact, // return contact to get ID in JS
                 'html' => view('admin.contacts.row', compact('contact'))->render()
             ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        \Illuminate\Support\Facades\Log::info('Destroy method hit for contact ID: ' . $contact->id);

        // Security check: non-admin users can only delete their own contacts
        if (auth()->user()->role !== 'admin' && $contact->user_id !== auth()->id()) {
            \Illuminate\Support\Facades\Log::warning('Unauthorized delete attempt by user ID: ' . auth()->id());
            abort(403, 'Unauthorized action.');
        }

        try {
            $this->contactService->delete($contact);
            \Illuminate\Support\Facades\Log::info('Contact deleted successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting contact: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Server Error'], 500);
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully.'
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
