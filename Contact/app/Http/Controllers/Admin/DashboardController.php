<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Admins see all contacts, regular users see only their own
        $contactQuery = Auth::user()->role === 'admin' 
            ? Contact::query() 
            : Contact::where('user_id', Auth::id());

        $stats = [
            'total_contacts' => (clone $contactQuery)->count(),
            'total_cities' => City::count(),
            'recent_contacts' => (clone $contactQuery)
                ->with('cities', 'user')
                ->latest()
                ->limit(5)
                ->get(),
        ];

        $cities = City::all();

        return view('admin.dashboard', compact('stats', 'cities'));
    }
}
