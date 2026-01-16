<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use App\Models\City;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        $contacts = $this->contactService->filterByCity([], $request->query('query'));
        $cities = City::all();

        if ($request->ajax()) {
            return view('contacts._table_body', compact('contacts'))->render();
        }

        return view('contacts.index', compact('contacts', 'cities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'photo' => 'nullable|image',
            'cities' => 'nullable|array',
            'cities.*' => 'exists:cities,id',
        ]);

        $this->contactService->create($data);

        if ($request->ajax()) {
            return view('contacts._table_body', ['contacts' => $this->contactService->getAll()]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contact créé avec succès !');
    }
}



