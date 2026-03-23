<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking\MaintenanceJob;
use App\Models\Booking\MaintenanceTicket;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Tinify\Tinify;
use Tinify\Source;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::guard('technician')->user();
        $tickets = $user->tickets()->latest()->get();

        return view('technicians.tickets.index', compact('tickets'));
    }

    public function show(int $ticketId)
    {
        $ticket = MaintenanceTicket::findOrFail($ticketId);

        return view('technicians.tickets.show', compact('ticket'));
    }

    public function uploadPhoto(Request $request, int $ticketId)
    {
        $ticket = MaintenanceTicket::findOrFail($ticketId);

        /// Tinify::set
        Tinify::setKey(config('tinify.api_key'));

        $uploadedFile = $request->file('photo');
        if ($request->hasFile('photo')) {
            $source = Source::fromFile($uploadedFile->getRealPath());

            // 4. Define the path and filename for the new optimized photo
            $newFileName = 'maintenance_ticket_evidence-' . time() . '.' . $uploadedFile->getClientOriginalExtension();
            $destinationPath = Storage::disk('public')->path('maintenance/' . $newFileName);

            $source->toFile($destinationPath);

            $publicPath = 'maintenance/' . $newFileName;
            
            //get full path of the photo
            // $fullPath = Storage::disk('public')->path($path);
            // OptimizerChainFactory::create()->optimize($fullPath);

            // Extract the photo name from the path
            $pathArray = explode('/', $publicPath);
            $imgPath = end($pathArray);
            // dd($imgPath);

            $ticket->update([
                'completion_photo_path' => $imgPath,
            ]);

            $ticket->save();
            

            return back()->with('success', 'Issue logged! Our team will look into it.');

        }
    }

    public function completeTicket(int $ticketId)
    {
        $ticket = MaintenanceTicket::findOrFail($ticketId);

        if(!$ticket->completion_photo_path){
            return back()->with('error', 'please upload a photo first');
        }

        $ticket->update([
            'completed_at' => now(),
            'status' => 'completed'
        ]);

        $ticket->save();

        $job = $ticket->job;

        $job->update([
            'status' => 'completed',
        ]);

        $job->save();

        return back()->with('success', 'Ticket successfully completed');
    }
}
