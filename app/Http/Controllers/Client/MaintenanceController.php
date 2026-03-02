<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking\MaintenanceJob;
use App\Models\Booking\MaintenanceTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Tinify\Tinify;
use Tinify\Source;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{

    public function index()
    {
        $firstResponseSubquery = DB::table('maintenance_tickets')
            ->select('maintenance_job_id', DB::raw('MIN(earliest_start_date) as first_responded_at'))
            ->groupBy('maintenance_job_id');

        // 2. Join this subquery to the jobs table and calculate the average
        $averageDays = DB::table('maintenance_jobs')
            ->joinSub($firstResponseSubquery, 'first_responses', function ($join) {
                $join->on('maintenance_jobs.id', '=', 'first_responses.maintenance_job_id');
            })
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, maintenance_jobs.created_at, first_responses.first_responded_at)) / 86400 as avg_days')
            ->value('avg_days');

        // dd($averageDays);

        $jobs = Auth::guard('web')->user()->room->maintenanceJobs()->latest()->get();

        $summary = [
            'room_number' => Auth::guard('web')->user()->room->room_number,
            'total_requests' => $jobs->count(),
            'last_request_amount' => $jobs->where('status', 'completed')->first()?->ticket?->cost ?? 0,
            'avg_response_time' => $averageDays,
            'last_service_date' => $jobs->where('status', 'completed')->first()?->updated_at?->format('d M Y') ?? 'N/A',
        ];

        return view('clients.maintenance.index', compact('jobs', 'summary'));
    }

    public function show(MaintenanceJob $job)
    {
        $ticket = MaintenanceTicket::where('maintenance_job_id', $job->id)->first();
        return view('clients.maintenance.show', compact('job', 'ticket'));
    }

    public function create()
    {
        // Categories for our dropdown
        $categories = ['Plumbing', 'Electrical', 'Structural', 'Appliances', 'Security', 'Other'];
        return view('clients.maintenance.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validated = $request->validate([
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        /// Tinify::set
        Tinify::setKey(config('tinify.api_key'));

        $uploadedFile = $request->file('image');
        if ($request->hasFile('image')) {
            $source = Source::fromFile($uploadedFile->getRealPath());

            // 4. Define the path and filename for the new optimized image
            $newFileName = 'maintenance_job-' . time() . '.' . $uploadedFile->getClientOriginalExtension();
            $destinationPath = Storage::disk('public')->path('maintenance/' . $newFileName);

            $source->toFile($destinationPath);

            $publicPath = 'maintenance/' . $newFileName;
            
            //get full path of the image
            // $fullPath = Storage::disk('public')->path($path);
            // OptimizerChainFactory::create()->optimize($fullPath);

            // Extract the image name from the path
            $pathArray = explode('/', $publicPath);
            $imgPath = end($pathArray);
            // dd($imgPath);

            $job = MaintenanceJob::create([
                'room_id' => auth()->user()->room_id,
                'category' => $validated['category'],
                'title' => $validated['title'] . ' Issue',
                'description' => $validated['description'],
                'status' => 'pending',
                'photo_url' => $imgPath,
            ]);

            return redirect()->route('dashboard')->with('success', 'Issue logged! Our team will look into it.');

        }

        dd($imagePath);
        

        $job = MaintenanceJob::create([
            'room_id' => auth()->user()->room_id,
            'category' => $validated['category'],
            'title' => $validated['title'] . ' Issue',
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Issue logged! Our team will look into it.');
    }

}
