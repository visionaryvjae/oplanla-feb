<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Payment as RentPayment;
use App\Models\Booking\Charge;
use Illuminate\Support\Facades\Auth;

class BillingsController extends Controller
{
    public function index(Request $request)
    {
        $tenant = Auth::guard('web')->user();
         
        // Fetch all unpaid charges (Rent, Water, Electricity)
        $query = Charge::query();
        $query->where('rooms_id', $tenant->room->id)->orderby('is_paid');

        if($request->filled('type')){
            $query->whereIn('type', $request->type);
        }

        if($request->filled('status')){
            $val = null;
            if($request->status == 'paid'){
                $val = 1;
            }
            else if($request->statu == 'unpaid'){
                $val = 0;
            }

            $query->Where('is_paid', $val);
        }

        // $charges = RoomCharge::where('rooms_id', $tenant->rooms_id)
        // ->when(request('type'), function($query) {
        //     $query->whereIn('type', request('type'));
        // })
        // ->when(request('status'), function($query) {
        //     $query->where('status', request('status'));
        // })
        // ->get();

        $totalOutstanding = $tenant->room->totalCharges();

        $charges = $query->get();
        return view('clients.charges.index', compact('charges', 'totalOutstanding'));
    }
}
