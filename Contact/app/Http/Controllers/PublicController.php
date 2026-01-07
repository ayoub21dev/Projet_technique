<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class PublicController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index(Request $request)
    {
        $query = Contact::with('cities');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('city') && $request->city != '') {
            $query->whereHas('cities', function($q) use ($request) {
                $q->where('cities.id', $request->city);
            });
        }

        $contacts = $query->paginate(9);
        $cities = \App\Models\City::all();

        return view('welcome', compact('contacts', 'cities'));
    }

    /**
     * Public search or directory if needed.
     */
    public function directory()
    {
        $contacts = Contact::with('cities')->get();
        return view('public.directory', compact('contacts'));
    }

}
