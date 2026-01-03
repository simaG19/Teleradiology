<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
// use App\Http\Controllers\Admin\FileType;
use App\Models\FileType;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class BatchController extends Controller
{

public function index(Request $request)
{
    $query = Batch::with(['user', 'uploader', 'fileType'])
                  ->orderByDesc('created_at');

    // Apply filters
    if ($request->filled('search')) {
        $query->where('id', 'LIKE', "%{$request->search}%")
              ->orWhereHas('uploader', function ($q) use ($request) {
                  $q->where('name', 'LIKE', "%{$request->search}%");
              });
    }

    if ($request->filled('urgency')) {
        $query->where('urgency', $request->urgency);
    }

    if ($request->filled('payment_status')) {
        $query->where('paid', $request->payment_status);
    }

    // Show only unconfirmed unless "all" is true
    if (! $request->boolean('all')) {
        $query->where(function ($q) {
            $q->where('confirmed', false)
              ->orWhereNull('confirmed');
        });
    }

    $batches = $query->get();

    // 👉 Send dropdown options to blade
    $urgencyOptions = ['Routine', 'Stat'];
    $paymentStatusOptions = ['paid', 'unpaid'];


    return view('admin.batches.index', compact('batches', 'urgencyOptions', 'paymentStatusOptions'));
}

public function download(Batch $batch)
{
    if (empty($batch->archive_path)) {
        return back()->withErrors(['download' => 'Archive path not set for this batch.']);
    }

    // Use storage disk local
    $disk = Storage::disk('local');
    if (! $disk->exists($batch->archive_path)) {
        return back()->withErrors(['download' => 'ZIP file not found on disk.']);
    }

    $fullPath = $disk->path($batch->archive_path); // full server path
    $downloadName = $batch->id . '.zip';

    return response()->download($fullPath, $downloadName);
}



    public function editQuote(Batch $batch)
    {
        return view('admin.batches.quote', compact('batch'));
    }


public function updateQuote(Request $request, Batch $batch)
{
    $data = $request->validate([
        'file_type_id' => 'required|exists:file_types,id',
        'quoted_price' => 'nullable|numeric|min:0',
    ]);

    $fileType = FileType::findOrFail($data['file_type_id']);

    // Use the file type's price directly (no count)
    $computedTotal = $fileType->price_per_file;

    // If admin passed a quoted_price use it, otherwise use computed total
    $total = isset($data['quoted_price']) ? $data['quoted_price'] : $computedTotal;

    $batch->update([
        'file_type_id'  => $fileType->id,
        'quoted_price'  => $total,
        'confirmed'     => true,
        'confirmed_by'  => Auth::id(),
        'confirmed_at'  => now(),
    ]);

    return redirect()->route('admin.batches.index')
                     ->with('success','Price sent to customer and batch confirmed.');
}


}
