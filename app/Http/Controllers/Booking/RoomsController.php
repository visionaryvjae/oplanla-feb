<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\Room;
use App\Models\Booking\Providers;
use App\Models\Booking\RoomFacilities;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Booking\Enquiry;
use App\Notifications\RentalInterestNotification;
use Illuminate\Support\Facades\Notification;

class RoomsController extends Controller
{
    protected $markup;

    public function __construct()
    {
        // Initialize the static property in the constructor
         $this->markup = Config::get('app.markup', 1);
    }

    public function index(Request $request) {
        
        $query = Room::query();

        // Search Filter
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
        
            $query->WhereHas('provider', function ($q) use ($search) {
                $q->where('booking_address', 'like', $search)->orWhere('provider_name', 'like', $search);
            });
        }

        // Property Type Filter
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Number of beds Filter
        if ($request->filled('num_beds')) {
            $query->where('num_beds', $request->num_beds);
        }

        // Use paginate() instead of get()
        $rooms = $query->latest()->paginate(10);
        
        
        return view('admin.rooms.rooms', ['rooms' => $rooms, 'pagetitle' => 'List of Rooms', ]);
    }

    public function indexProvider() {
        $pid = Auth::guard('provider')->user()->provider->id;
        $rooms = DB::select('SELECT rooms.id, provider_name, room_number, room_type, available, price, num_people, room_facilities, property_type from rooms JOIN providers ON rooms.providers_id = providers.id WHERE providers.id = ?', [$pid]);
        return view('providers.rooms.rooms', ['rooms' => $rooms, 'pagetitle' => 'List of Rooms', ]);
    }


    public function viewSingle(int $id) {
        
        $room = Room::findOrFail($id);
        
        $roomModel = Room::find($id);
        $reviews = $room->provider->review;
        
        $shareUrl = route('rooms.single', $room);
        
        if(!$room){
            return view('Booking.Rooms.room', ['room' => $room]);
        }
        return view('Booking.Rooms.room', ['room' => $room, 'reviews' => $reviews, 'shareUrl' => $shareUrl]);
    }

    public function viewSingleRental(int $id) {
        
        $room = Room::findOrFail($id);
        
        $roomModel = Room::find($id);
        $reviews = $roomModel->provider->review;
        
        $shareUrl = route('rental.show', $room);
        
        
        if(!$room){
            return view('Booking.Rooms.room', ['room' => $room]);
        }
        return view('Booking.Rooms.rental', ['room' => $room, 'reviews' => $reviews, 'shareUrl' => $shareUrl]);
    }

    public function roomsLanding(Request $request) {
        
        
        $locationArray = explode(',', $request->search);

        $location = $locationArray[0];
        // dd($location);
        $query = Room::query();
        
        $query->where('available', true)
            ->where('room_type', '<>', "Conference Room")
            ->where('rental', '<>', true);

        // Search Filter
        if ($request->filled('search')) {
            $search = '%' . $location . '%';
            // dd($search);
        
            $query->WhereHas('provider', function ($q) use ($search) {
                $q->where('booking_address', 'like', $search)
                ->orWhere('provider_name', 'like', $search);
            });
        }

        // Property Filter
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Number of Beds Filter
        if ($request->filled('num_beds')) {
            $query->where('num_beds', $request->num_beds);
        }
        
        // Min Price filter
        if ($request->filled('min_price')) {
            $reverseMarkup = bcdiv(1/$this->markup, 1, 2);
            $price = $request->min_price * $reverseMarkup;
            $query->where('price', '>=' ,$price);
        }
        
        // Max Price filter
        if ($request->filled('max_price')) {
            $reverseMarkup = bcdiv(1/$this->markup, 1, 2);
            $price = $request->max_price * $reverseMarkup;
            $query->where('price', '<=' ,$price);
        }

        // Use paginate() instead of get()
        $rooms = $query->latest()->paginate(9);
    
            
            
        return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'Find Rooms']); //=> $rooms, 'pagetitle' => 'All Individual Rooms',]);
    }

    public function rentalsLanding(Request $request) {
        
        $locationArray = explode(',', $request->search);

        $location = $locationArray[0];
        
        $query = Room::query();
        
        $query->where('rental', true)
            ->where('available', true)
            ->where('room_type', '<>', "Conference Room")
            ->orderBy('created_at','desc')
            ->paginate(9);
            
            
        // Search Filter
        if ($request->filled('search')) {
            $search = '%' . $location . '%';
        
            $query->WhereHas('provider', function ($q) use ($search) {
                $q->where('booking_address', 'like', $search)
                ->orWhere('provider_name', 'like', $search);
            });
        }

        // Property Filter
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Number of Beds Filter
        if ($request->filled('num_beds')) {
            $query->where('num_beds', $request->num_beds);
        }
        
        // Min Price filter
        if ($request->filled('min_price')) {
            $query->where('rental_price', '>=' ,$request->min_price);
        }
        
        // Max Price filter
        if ($request->filled('max_price')) {
            $query->where('rental_price', '<=' ,$request->max_price);
        }

        // Use paginate() instead of get()
        $rooms = $query->latest()->paginate(9);
            
        return view('Booking.Rooms.rooms', ['rooms' => $rooms, 'pagetitle' => 'Find Rooms', 'rental' => true]); //=> $rooms, 'pagetitle' => 'All Individual Rooms',]);
    }
    
    
    public function providerFilter(Request $request) {
        $rooms = Room::orderBy('created_at', 'desc')
            ->where('available', true)
            ->where('rental', false)
            ->where('room_type', '<>', "Conference Room")
            ->where('providers_id', $request->input('provider_id'))
            ->paginate(9);
            
//        dd($rooms);
        if($rooms->count() <= 0){
            $rooms = Room::orderBy('created_at', 'desc')
            ->where('available', true)
            ->where('rental', '<>', false)
            ->where('room_type', '<>', "Conference Room")
            ->where('providers_id', $request->input('provider_id'))
            ->paginate(9);
            
            return view('Booking.Rooms.rooms', ['rental' => true, 'rooms' => $rooms, 'pagetitle' => 'Find Rental Rooms']);
        }
            
            
        return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'Find Rooms']); //=> $rooms, 'pagetitle' => 'All Individual Rooms',]);
    }

    public function CityFilter(Request $request){
        $location = $request->input('city');

        $rooms = Room::leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
            ->select('rooms.*')
            ->where('rental', '<>', true)
            ->where('available', true)
            ->where('room_type', '<>', "Conference Room")
            ->where('providers.booking_address', 'like', '%'.$location.'%')
            ->paginate(9);

        if($rooms->count() > 0){
            return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'Results for: '.$location]);
        }
        
        return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'No results found for: '.$location]);
    }

    public function PropertyFilter(Request $request){
        $propertyType = $request->input('property_type');
        
        $rooms = Room::where('available', true)
            ->where('rental', '<>', true)
            ->where('room_type', '<>', "Conference Room")
            ->where('property_type', 'like', '%'.$propertyType.'%')
            ->paginate(9);
        
        if($rooms->count() > 0){
            return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'Results for: '.$propertyType]);
        }
        return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'No results found for: '.$propertyType]);
    }
    
    
    public function ConferenceFilter(Request $request){
        $location = $request->input('location');
        
        $rooms = Room::leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
            ->where('available', true)
            ->select('rooms.*')
            ->where('rental', '<>', true)
            ->where('room_type', '=', 'Conference Room')
            ->where('providers.booking_address', 'like', '%'.$location.'%')
            ->paginate(9);
        
        if($rooms->count() > 0){
            return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'Results for: '.$location]);
        }
        return view('Booking.Rooms.rooms', ['rental' => false, 'rooms' => $rooms, 'pagetitle' => 'No results found for: '.$location]);
    }

    public function liveFilter(Request $request)
    {
        $locationArray = explode(',', $request->input('location'));

        $location = $locationArray[0];

        // dd($locationArray);
        $maxPrice = $request->input('max_price');
        $minPrice = $request->input('min_price');
        $numBeds = $request->input('num_beds');
        $propertyType = $request->input('property_type');

        // Start building the query
        $query = Room::query()
            ->select([
                'rooms.id',
                DB::raw("rooms.price * {$this->markup} as price"),
                'rooms.num_people',
                'rooms.room_type',
                'providers.id as provider_id',
                'providers.booking_address',
                'providers.provider_name',
                DB::raw('AVG(reviews.rating) as rating'),
                DB::raw('COUNT(DISTINCT reviews.id) as num_reviews'),
                DB::raw('GROUP_CONCAT(photos.image SEPARATOR ",") as images'),
            ])
            ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
            ->leftJoin('reviews', 'providers.id', '=', 'reviews.providers_id')
            ->leftJoin('photos', 'providers.id', '=', 'photos.providers_id')
            ->where('rooms.available', true)
            ->where('rental', '<>', true)
            ->where('rooms.room_type', '<>', "Conference Room")
            ->groupBy([
                'rooms.id',
                'rooms.price',
                'rooms.num_people',
                'rooms.room_type',
                'providers.provider_name',
                'providers.id',
                'providers.booking_address'
            ]);

        // Apply filters conditionally
        if ($location) {
            $query->where('providers.booking_address', 'like', '%' . $location . '%');
        }

        if ($propertyType) {
            $query->where('rooms.property_type', 'like', '%' . $propertyType . '%');
        }

        if ($minPrice) {
            $query->where('rooms.price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('rooms.price', '<=', $maxPrice);
        }

        if($numBeds){
            $query->where('rooms.num_beds', '=', $numBeds);
        }

        $rooms = $query->get();

        // if($rooms->count() > 0){
        //     return view('Booking.Rooms._rooms-list', ['rooms' => $rooms]);
        // }
        // else

        // Return the partial view with the rooms data
        return view('Booking.Rooms._rooms-list', ['rooms' => $rooms, 'search' => $location]);
    }
    
    public function roomsLiveFilter(Request $request)
    {
        $locationArray = explode(',', $request->input('location'));

        $location = $locationArray[0];

        // dd($locationArray);
        $maxPrice = $request->input('max_price');
        $minPrice = $request->input('min_price');
        $numBeds = $request->input('num_beds');
        $propertyType = $request->input('property_type');

        // Start building the query
        $query = Room::query()
            ->select([
                'rooms.id',
                DB::raw("rooms.price * {$this->markup} as price"),
                'rooms.num_people',
                'rooms.room_type',
                'providers.id as provider_id',
                'providers.booking_address',
                'providers.provider_name',
                DB::raw('AVG(reviews.rating) as rating'),
                DB::raw('COUNT(DISTINCT reviews.id) as num_reviews'),
                DB::raw('GROUP_CONCAT(photos.image SEPARATOR ",") as images'),
            ])
            ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
            ->leftJoin('reviews', 'providers.id', '=', 'reviews.providers_id')
            ->leftJoin('photos', 'providers.id', '=', 'photos.providers_id')
            ->where('rooms.available', true)
            ->where('rooms.room_type', '<>', "Conference Room")
            ->groupBy([
                'rooms.id',
                'rooms.price',
                'rooms.num_people',
                'rooms.room_type',
                'providers.provider_name',
                'providers.id',
                'providers.booking_address'
            ]);

        // Apply filters conditionally
        if ($location) {
            $query->where('providers.booking_address', 'like', '%' . $location . '%');
        }

        if ($propertyType) {
            $query->where('rooms.property_type', 'like', '%' . $propertyType . '%');
        }

        if ($minPrice) {
            $query->where('rooms.price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('rooms.price', '<=', $maxPrice);
        }

        if($numBeds){
            $query->where('rooms.num_beds', '=', $numBeds);
        }

        $rooms = $query->get();

        // if($rooms->count() > 0){
        //     return view('Booking.Rooms._rooms-list', ['rooms' => $rooms]);
        // }
        // else

        // Return the partial view with the rooms data
        return view('Booking.Rooms.rooms', ['rooms' => $rooms, 'search' => $location]);
    }

    public function RoomsFilter(Request $request){
        $location = $request->input('location');
        $maxPrice = $request->input('max_price');
        $minPrice = $request->input('min_price');
        $propertyType = $request->input('property_type');

        if(!$maxPrice){
            $maxPrice = 5000;
        }

        if(!$minPrice){
            $minPrice = 0;
        }

        $rooms = Room::select([
            'rooms.id',
            DB::raw("rooms.price * {$this->markup} as price"),
            'rooms.num_people',
            'rooms.room_type',
            'providers.id as provider_id',
            'providers.booking_address',
            'providers.provider_name',
            DB::raw('AVG(reviews.rating) as rating'),
            DB::raw('COUNT(DISTINCT reviews.id) as num_reviews'),
            DB::raw('GROUP_CONCAT(photos.image SEPARATOR ",") as images'),
        ])
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->leftJoin('reviews', 'providers.id', '=', 'reviews.providers_id')
        ->leftJoin('photos', 'providers.id', '=', 'photos.providers_id')
        // ->leftJoin('booking_rooms', 'rooms.id', '=', 'booking_rooms.rooms_id')
        // ->leftJoin('room_bookings', function ($join) use ($checkInDate, $checkOutDate) {
        //     $join->on('room_bookings.id', '=', 'booking_rooms.bookings_id')
        //         ->where('room_bookings.check_in_time', '<', $checkOutDate)
        //         ->where('room_bookings.check_out_time', '>', $checkInDate);
        // })
        // Apply conditional filters based on input parameters
        ->where('rooms.property_type', 'like', '%' . $propertyType . '%')
        ->where('providers.booking_address', 'like', '%' . $location . '%')
        ->where('rooms.price', '>', $minPrice)
        ->where('rooms.price', '<', $maxPrice)
        ->where('rooms.available', true)
        ->groupBy([
            'rooms.id',
            'rooms.price',
            'rooms.num_people',
            'rooms.room_type',
            'providers.provider_name',
            'providers.id',
            'providers.booking_address'
        ])
        ->paginate(9);
        // dd($rooms);

        // Check if the result is empty
        if (!$rooms) {
            // Handle the case where no results are found
            return view('Booking.noResults', ['pagetitle' => 'No Matching Results']);
        }

        return view('Booking.Rooms.searchedRooms', ['rooms' => $rooms, 'pagetitle' => 'Filter Results']);
    }


    public function search(Request $request){

        $locationArray = explode(',', $request->input('location'));

        $location = $locationArray[0];

        dd($location);

        $rooms = Room::select([
            'rooms.id',
            DB::raw("rooms.price * {$this->markup} as price"),
            'rooms.num_people',
            'rooms.room_type',
            'providers.id as provider_id',
            'providers.booking_address',
            'providers.provider_name',
            DB::raw('AVG(reviews.rating) as rating'),
            DB::raw('COUNT(DISTINCT reviews.id) as num_reviews'),
            DB::raw('GROUP_CONCAT(photos.image SEPARATOR ",") as images'),
        ])
        ->leftJoin('providers', 'rooms.providers_id', '=', 'providers.id')
        ->leftJoin('reviews', 'providers.id', '=', 'reviews.providers_id')
        ->leftJoin('photos', 'providers.id', '=', 'photos.providers_id')
        // ->leftJoin('booking_rooms', 'rooms.id', '=', 'booking_rooms.rooms_id')
        // ->leftJoin('room_bookings', function ($join) use ($checkInDate, $checkOutDate) {
        //     $join->on('room_bookings.id', '=', 'booking_rooms.bookings_id')
        //         ->where('room_bookings.check_in_time', '<', $checkOutDate)
        //         ->where('room_bookings.check_out_time', '>', $checkInDate);
        // })
        // Apply conditional filters based on input parameters
        ->where('providers.booking_address', 'like', '%' . $location . '%')
        ->where('rooms.available', true)
        ->groupBy([
            'rooms.id',
            'rooms.price',
            'rooms.num_people',
            'rooms.room_type',
            'providers.provider_name',
            'providers.id',
            'providers.booking_address'
        ])
        ->paginate(9);
        // dd($rooms);

        // Check if the result is empty
        if (!$rooms) {
            // Handle the case where no results are found
            return view('Booking.noResults', ['pagetitle' => 'No Matching Results']);
        }

        return view('Booking.Rooms.searchedRooms', ['rooms' => $rooms, 'pagetitle' => 'Filter Results']);
    }

    public function viewSingleAdmin(int $id) {
        $room = Room::findOrFail($id);
        // dd($room);
        return view('admin.rooms.room', ['room' => $room]);
    }

    public function create(){
        $room = new Room();
        $providers = Providers::all();
        return view('Booking/booking_form', ['room' => $room, 'table' => 'Room', 'providers' => $providers, 'action' => 'Create', 'actionUrl' => route('admin.rooms.store')]);
    }

    public function createSingle(int $id){
        $room = new Room();
        $providers = DB::select('SELECT id, provider_name from providers');
        return view('Booking.booking_form', ['room' => $room, 'table' => 'Room', 'providerId' => $id, 'providers' => $providers, 'action' => 'CreateProvider', 'actionUrl' => route('admin.rooms.store')]);
    }

    public function store(Request $request){
        // dd($request);
        $validationData = $request-> validate([
            'available' => 'boolean',
            'price' => 'required|numeric',
            'num_people' => 'integer',
            'room_type' => 'string',
            'room_facilities' => 'string',
            'provider_facilities' => 'string',
            'property_type' => 'string|max:20',
            'room_number' => 'integer',
            'rental' => 'boolean',
            'num_beds' => 'integer',
            'num_bathrooms' => 'integer',
            'rental_price' => 'nullable|numeric',
            'furnishing' => 'in:furnished,unfurnished,partially furnished',
            'providers_id' => 'required|integer',
            
        ]);
        
        $isRental = $request->has('rental') ? true : false;
        
        $validationData['rental'] = $isRental;

        $room = Room::create($validationData);
        $provider = $room->provider->update([
            'provider_facilities' => $validationData['provider_facilities']    
        ]);
        
        return redirect()->route('admin.rooms.index')->with('success','successfully entered room');
    }

    public function edit(int $id) {
        $room = Room::findOrFail($id);
        $provider = DB::select('SELECT id, provider_name from providers');
        return view('Booking/booking_form', ['room' => $room, 'table' => 'Room', 'providers' => $provider, 'action' => 'Update', 'actionUrl' => route('admin.rooms.update', $id)]);
    }

    public function update(int $id, Request $request){
        $room = Room::findOrFail($id);
        $room->price = $request->input('price');
        $room->num_people = $request->input('num_people');
        $room->room_number = $request->input('room_number');
        $room->room_facilities = $request->input('room_facilities');
        $room->property_type = $request->input('property_type');
        $room->available = $request->input('available');
        $room->room_type = $request->input('room_type');
        $room->rental = $request->input('rental');
        $room->num_beds = $request->input('num_beds');
        $room->num_bathrooms = $request->input('num_bathrooms');
        $room->rental_price = $request->input('rental_price');
        $room->furnishing = $request->input('furnishing');

        $room->save();
        return redirect()->route('admin.rooms.index')->with('success', 'successfully edited room details');
    }

    public function delete(int $id){
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'room deleted successfully');
    }
}
