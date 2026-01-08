<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('cities');

        if ($search = $request->get('search')) {
            $query->where(fn($q) => $q
                ->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
            );
        }

        return view('welcome', ['contacts' => $query->paginate(9)]);
    }

    public function directory(Request $request)
    {
        $query = Contact::with('cities');

        if ($search = $request->get('search')) {
            $query->where(fn($q) => $q
                ->where('nom', 'like', "%{$search}%")
                ->orWhere('prenom', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
            );
        }

        return view('directory', ['contacts' => $query->paginate(12)]);
    }
}
