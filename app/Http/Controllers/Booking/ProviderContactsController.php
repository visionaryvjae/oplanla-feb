<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\ProviderContacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderContactsController extends Controller
{
    public function create(int $id){
        $contact = new ProviderContacts();
        $providers = DB::select('SELECT id, provider_name from providers');
        return view('Booking/booking_form', ['contact' => $contact, 'providers' => $providers, 'providerId' => $id, 'action' => 'Create', 'table' => 'Contact', 'actionUrl' => route('contact.store', $id)]);
    }

    public function store(Request $request, int $id){
        $validData = $request->validate([
            'email' => 'string',
            'phone' => 'string'
        ]);

        $contact = new ProviderContacts();
        $contact->providers_id = $id;
        $contact->email = $validData['email'];
        $contact->phone = $validData['phone'];
        $contact->save();
        return redirect()->route('providers.index')->with('success', 'successfully uploaded image');
    }

    public function edit(int $pid, int $id) {
        $contact = ProviderContacts::findOrFail($id);
        return view('Booking/booking_form', ['contact' => $contact, 'table' => 'Contact', 'action' => 'Update', 'actionUrl' => route('contact.update', [$pid, $id])]);
    }

    public function update(Request $request, int $pid, int $id) {
        $contact = ProviderContacts::findOrFail($id);
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->providers_id = $pid;
        $contact->save();
        return redirect()->route('providers.single', [$pid])->with('success', 'successfully update image');
    }

    public function delete(int $pid, int $id){
        $contact = ProviderContacts::findOrFail($id);
        $contact->delete();
        return redirect()->route('providers.single', [$pid])->with('success', 'provider deleted successfully');
    }
}
