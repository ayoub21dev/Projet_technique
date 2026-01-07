<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount('contacts')->get();
        return view('admin.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:255|unique:cities']);
        City::create($request->all());
        return back()->with('success', 'City added successfully.');
    }

    public function update(Request $request, City $city)
    {
        $request->validate(['nom' => 'required|string|max:255|unique:cities,nom,' . $city->id]);
        $city->update($request->all());
        return back()->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        if ($city->contacts()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete city as it is linked to contacts.']);
        }
        $city->delete();
        return back()->with('success', 'City deleted successfully.');
    }
}
