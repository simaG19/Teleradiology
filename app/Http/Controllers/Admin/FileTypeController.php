<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class FileTypeController extends Controller
{
    public function index()
    {
        $types = FileType::orderBy('name')->get();
        return view('admin.file_types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.file_types.create');
    }

public function store(Request $request)
{
    $data = $request->validate([
        'name'           => [
            'required',
            'string',
            // unique for the combination (name + anatomy)
            Rule::unique('file_types')->where(function ($query) use ($request) {
                return $query->where('anatomy', $request->input('anatomy'));
            }),
        ],
        'price_per_file' => 'required|numeric|min:0',
        'anatomy'        => 'nullable|string|max:100',
    ]);

    FileType::create($data);

    return redirect()->route('admin.file_types.index')->with('success', 'File type created.');
}


    public function edit(FileType $fileType)
    {
        return view('admin.file_types.edit', compact('fileType'));
    }

public function update(Request $request, FileType $fileType)
{
    $data = $request->validate([
        'name' => [
            'required',
            'string',
            Rule::unique('file_types')->where(function ($query) use ($request) {
                return $query->where('anatomy', $request->input('anatomy'));
            })->ignore($fileType->id),
        ],
        'price_per_file' => 'required|numeric|min:0',
        'anatomy' => 'nullable|string|max:100',
    ]);

    $fileType->update($data);

    return redirect()->route('admin.file_types.index')->with('success', 'File type updated.');
}


    public function destroy(FileType $fileType)
    {
        $fileType->delete();

        return back()->with('success', 'File type deleted.');
    }
}
