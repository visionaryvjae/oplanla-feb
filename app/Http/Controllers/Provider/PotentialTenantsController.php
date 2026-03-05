<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking\Enquiry;
use App\Models\User;
use App\Models\Booking\EnquiryResponse;
use App\Models\Booking\TenantDocuments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DocumentsVerifiedNotification;
use App\Notifications\DocumentsRejectedNotification;

class PotentialTenantsController extends Controller
{
    public function index()
    {
        $providerId = Auth::Guard('provider')->user()->provider->id;
        $query = TenantDocuments::query();

        $query->whereHas('enquiry.room.provider', function($q) use($providerId){
            $q->where('id', $providerId);
        });

        // dd($query->latest()->get(), $providerId);


        $documents = $query->latest()->paginate(9);

        return view('providers.tenant_documents.index', ['tenant_documents' => $documents, 'pagetitle' => 'Tenant Documents']);
    }

    public function show(int $documentsId)
    {
        $documents = TenantDocuments::findOrFail($documentsId);

        return view('providers.tenant_documents.show', ['documents' => $documents]);
    }

    public function accept(int $documentsId)
    {
        $documents = TenantDocuments::findOrFail($documentsId);
        $user = $documents->tenant;
        // dd($user);

        $documents->update([
            'all_documents_verified' => true,
        ]);

        $documents->save();

        $user->notify(new DocumentsVerifiedNotification($documents));

        return redirect()->route('provider.potential-tenant.index')->with('success', 'successfully verified tenant documents');
    }

    public function reject(Request $request, int $documentsId)
    {
        // dd($request);
        $documents = TenantDocuments::findOrFail($documentsId);
        $user = $documents->tenant;

        $documents->update([
            'all_documents_verified' => false,
            'status' => 'rejected',
            'comments' => $request['comments'] ?? null,
        ]);

        $documents->save();

        // dd($user);
        $user->notify(new DocumentsRejectedNotification($documents));

        return redirect()->route('provider.potential-tenant.index')->with('success', 'tenant documents rejected successfully');
    }

    public function showDocument(Request $request)
    {
        // dd($request);
        $path = $request->input('filename');
        // dd($path);
        // Optional: Add authorization
        if (!Auth::guard('provider')->check() and !Auth::guard('admin')->check()) {
            abort(403, 'Access denied');
        };

        // Check if the file exists before attempting to serve it
        if (!Storage::disk('local')->exists($path)) {
            // dd("path not found");
            abort(404);
        }

        return Storage::disk('local')->response($path);
    }
}
