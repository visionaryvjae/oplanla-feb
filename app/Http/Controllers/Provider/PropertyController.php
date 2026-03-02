<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking\Property;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        $query->where('providers_id', Auth::guard('provider')->user()->provider->id)->get();

        if($request->filled('search')){
            $serach = '%' . $request->search . '%';
            $query->where('name', 'like', $serach)
                ->orWhere('description', 'like', $serach)
                ->orWhere('address', 'like', $serach);
        }

        $pagetitle = 'Properties';

        $properties = $query->latest()->paginate(10);
        return view('providers.properties.index', compact('properties', 'pagetitle'));
    }

    public function show(int $pid)
    {
        $property = Property::findOrFail($pid);
        return view('providers.properties.show', compact('property'));
    }

    public function create()
    {
        $property = new Property();
        return view('providers.properties.form', ['property' => $property, 'actionUrl' => route('provider.properties.store'), 'action' => 'Create', 'method' => 'POST']);
    }

    public function store(Request $request)
    {
        // dd($request);
        $validationData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $property = Property::create($validationData + ['providers_id' => Auth::guard('provider')->user()->provider->id]);  

        return redirect()->route('provider.properties.index')->with('success', 'Property created successfully.');

    }


    public function edit(Property $property)
    {
        return view('providers.properties.form', ['property' => $property, 'actionUrl' => route('provider.properties.update', $property->id), 'action' => 'Update', 'method' => 'POST']);    
    }


    public function update(Request $request, Property $property)
    {
        // dd($request, $property);
        $property = Property::findOrFail($property->id);

        $validationData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $property->update([
            'name' => $validationData['name'],
            'address' => $validationData['address'],
        ]);

        $property->save();

        return redirect()->route('provider.properties.index')->with('success', 'Property updated successfully.');

    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('provider.properties.index')->with('success', 'Property deleted successfully.');
    }
}
