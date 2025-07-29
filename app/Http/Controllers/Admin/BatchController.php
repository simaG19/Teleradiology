<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
// use App\Http\Controllers\Admin\FileType;
use App\Models\FileType;
class BatchController extends Controller
{
   public function index()
{
    $batches = Batch::with('user')
                    ->orderByDesc('created_at')
                    ->get();

    return view('admin.batches.index', compact('batches'));
}

    public function download(Batch $batch)
{
    // Adjust this path if your ZIPs are stored somewhere else:
    $zipPath = storage_path("app/batches/{$batch->id}.zip");

    if (! file_exists($zipPath)) {
        return back()->withErrors(['download' => 'ZIP file not found.']);
    }

    return response()->download($zipPath, "{$batch->id}.zip");
}


    public function editQuote(Batch $batch)
    {
        return view('admin.batches.quote', compact('batch'));
    }
public function updateQuote(Request $request, Batch $batch)
{
    $data = $request->validate([
        'file_type_id' => 'required|exists:file_types,id',
    ]);

    $fileType = FileType::findOrFail($data['file_type_id']);
    $count    = $batch->images()->count();
    $total    = $fileType->price_per_file * $count;

    // DEBUG: confirm we hit this point and see values
    // dd($batch->id, $fileType->id, $count, $total);

    // Direct assignment:
    $batch->file_type_id = $fileType->id;
    $batch->quoted_price = $total;
    $saved = $batch->save();

    // DEBUG: did it save?
    // dd('saved?', $saved, $batch->fresh()->only(['file_type_id','quoted_price']));

    return redirect()->route('admin.batches.index')
                     ->with('success','Price sent to customer.');
}


}
