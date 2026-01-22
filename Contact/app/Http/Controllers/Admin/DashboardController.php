<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(protected \App\Services\ContactService $contactService) {}

    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->input('search');
        
        // If searching, use the filter service. Otherwise, get recent 5.
        // Note: The user might want *all* contacts if they are scrolling/paginating, 
        // but for now let's stick to: Search -> Found results; No Search -> Recent 5.
        
        if ($search) {
            $contacts = $this->contactService->filterByCity([], $search);
        } else {
            // Replicate the 'recent' logic but we need it as a collection for the view
            $contactQuery = Contact::query();
            
            $contacts = $contactQuery->with('cities', 'user')->latest()->limit(5)->get();
        }

        if ($request->ajax()) {
            return view('admin.contacts.rows', compact('contacts'))->render();
        }



        return view('admin.dashboard', [
            'contacts' => $contacts,
            'cities' => City::all(),
            'search' => $search
        ]);
    }
}
