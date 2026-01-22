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
        $cityIds = $request->input('cities', []);
        
        $contacts = $this->contactService->filterByCity($cityIds, $search, 10);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.contacts.rows', compact('contacts'))->render(),
                'pagination' => (string) $contacts->appends($request->all())->links()
            ]);
        }

        return view('admin.dashboard', [
            'contacts' => $contacts,
            'cities' => City::all(),
            'search' => $search,
            'selectedCities' => $cityIds
        ]);
    }
}
