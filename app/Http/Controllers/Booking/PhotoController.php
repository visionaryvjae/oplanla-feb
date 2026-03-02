<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationData;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Tinify\Tinify;
use Tinify\Source;

class PhotoController extends Controller
{
    public function index(int $id){
        $photos = DB::select('SELECT * from photos WHERE providers_id = ?', [$id]);
        $provider = DB::select('SELECT id, provider_name from providers WHERE id = ?', [$id]);
        return view('admin/images/viewImages', ['photos' => $photos, 'provider' => $provider[0]]);
    }

    public function show(int $pid, int $id){
        $photo = DB::select('SELECT * from photos WHERE providers_id = ? AND id = ?', [$pid, $id]);
        // dd($photo);
        return view('admin/images/showImage', ['photo' => $photo[0], 'providerId' => $pid]);
    }

    public function create(int $id){
        $photo = new Photo();
        $providers = DB::select('SELECT id, provider_name from providers');
        return view('Booking/booking_form', ['photo' => $photo, 'providers' => $providers, 'action' => 'Create', 'table' => 'Image', 'actionUrl' => route('image.store', $id)]);
    }

    public function store(Request $request, int $id){
        // dd(config('tinify.api_key'));
        Tinify::setKey(config('tinify.api_key'));

        // dd($request);
        $validData = $request->validate(['area' => 'string',]);

        $uploadedFile = $request->file('image');
        if (!$request->hasFile('image')) {
            return back()->with('error', 'file did not upload corrrectly');
        }
        $source = Source::fromFile($uploadedFile->getRealPath());

        


        // 4. Define the path and filename for the new optimized image
        $newFileName = 'room-' . time() . '.' . $uploadedFile->getClientOriginalExtension();
        $destinationPath = Storage::disk('public')->path('images/' . $newFileName);

        $source->toFile($destinationPath);

        $publicPath = 'images/' . $newFileName;
        
        //get full path of the image
        // $fullPath = Storage::disk('public')->path($path);
        // OptimizerChainFactory::create()->optimize($fullPath);

        // Extract the image name from the path
        $pathArray = explode('/', $publicPath);
        $imgPath = end($pathArray);

        $photo = new Photo();
        $photo->image = $imgPath;
        $photo->area = $validData['area'];
        $photo->providers_id = $id;
        $photo->save();
        return redirect()->route('image.index', $id)->with('success', 'successfully uploaded image');
    }

    public function edit(int $pid, int $id) {
        $photo = Photo::findOrFail($id);
        return view('Booking/booking_form', ['photo' => $photo, 'table' => 'Image', 'action' => 'Update', 'actionUrl' => route('image.update', [$pid, $id])]);
    }

    public function update(Request $request, int $pid, int $id) {
        Tinify::setKey(config('tinify.api_key'));
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
            $source = Source::fromFile($newImage->getRealPath());

            $newFileName = 'room-' . time() . '.' . $newImage->getClientOriginalExtension();

            //then delete old image from storage
            Storage::disk('public')->delete($request['image-name']);

            $destinationPath = Storage::disk('public')->path('images/' . $newFileName);

            $source->toFile($destinationPath);

            $imgArray = explode('/', $destinationPath);
            $imgPath = end($imgArray);
            // dd($imgPath, $destinationPath);

            $photo->image = $imgPath;
        }

        
        $photo->area = $request->input('area');
        $photo->save();
        return redirect()->route('image.index', [$pid])->with('success', 'successfully update image');
    }

    public function delete(int $pid, int $id){
        $photo = Photo::findOrFail($id);
        $photo->delete();
        return redirect()->route('image.index', [$pid])->with('success', 'provider deleted successfully');
    }
}
