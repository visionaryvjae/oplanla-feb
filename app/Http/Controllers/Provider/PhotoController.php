<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationData;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PhotoController extends Controller
{
    public function index(int $id){
        $photos = DB::select('SELECT * from photos WHERE providers_id = ?', [$id]);
        $provider = DB::select('SELECT id, provider_name from providers WHERE id = ?', [$id]);
        return view('providers/images/viewImages', ['photos' => $photos, 'provider' => $provider[0]]);
    }

    public function show(int $pid, int $id){
        $photo = DB::select('SELECT * from photos WHERE providers_id = ? AND id = ?', [$pid, $id]);
        // dd($photo);
        return view('providers/images/showImage', ['photo' => $photo[0], 'providerId' => $pid]);
    }

    public function create(int $id){
        $photo = new Photo();
        $providers = DB::select('SELECT id, provider_name from providers');
        return view('providers/form/booking_form', ['photo' => $photo, 'providers' => $providers, 'action' => 'Create', 'table' => 'Image', 'actionUrl' => route('provider.image.store', $id)]);
    }

    public function store(Request $request, int $id){
        $validData = $request->validate(['area' => 'string',]);
        $path = $request->file('image')->store('images','public');
        
        //get full path of the image
        $fullPath = Storage::disk('public')->path($path);
        OptimizerChainFactory::create()->optimize($fullPath);

        // Extract the image name from the path
        $pathArray = explode('/', $path);
        $imgPath = $pathArray[1];

        $photo = new Photo();
        $photo->image = $imgPath;
        $photo->area = $validData['area'];
        $photo->providers_id = $id;
        $photo->save();
        return redirect()->route('provider.image.index', $id)->with('success', 'successfully uploaded image');
    }

    public function edit(int $pid, int $id) {
        $photo = Photo::findOrFail($id);
        return view('providers/form/booking_form', ['photo' => $photo, 'table' => 'Image', 'action' => 'Update', 'actionUrl' => route('provider.image.update', [$pid, $id])]);
    }

    public function update(Request $request, int $pid, int $id) {
        $photo = Photo::findOrFail($id);

        if ($request->hasFile('image')) {
            // Get the old image path
            $oldImagePath = public_path('images/' . $request['image-name']);

            // Delete the old image from storage if it exists
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Store the new image
            $newImage = $request->file('image');

            //then delete old image from storage
            Storage::disk('public')->delete($request['image-name']);

            $path = $newImage->store('images', 'public');

            $fullPath = Storage::disk('public')->path($path);
            OptimizerChainFactory::create()->optimize($fullPath);

            $imgPath = explode('/', $path)[1];

            $photo->image = $imgPath;
        }

        
        $photo->area = $request->input('area');
        $photo->save();
        return redirect()->route('provider.image.index', [$pid])->with('success', 'successfully update image');
    }

    public function delete(int $pid, int $id){
        $photo = Photo::findOrFail($id);
        $photo->delete();
        return redirect()->route('provider.image.index', [$pid])->with('success', 'provider deleted successfully');
    }
}
