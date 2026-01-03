{{-- resources/views/reader/assignments/report-create.blade.php --}}
<x-read-lay>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-semibold">Create Report</h2>
        <p class="text-sm text-gray-500">Write findings and attach optional PDF report for batch <span class="font-mono">{{ $batch_no }}</span></p>
      </div>
      <div>
        <a href="{{ route('reader.assignments.index') }}"
           class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
          ← Back to assignments
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">

      {{-- flash / errors --}}
      @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-50 border border-green-200 text-green-700 rounded">
          {{ session('success') }}
        </div>
      @endif

      @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded">
          <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Batch details (hospital or images) --}}
      <div class="mb-6 p-4 bg-gray-50 rounded">
        <div class="flex items-start justify-between">
          <div>
            <p class="text-sm text-gray-600">Batch ID</p>
            <p class="font-mono text-sm text-gray-900">{{ $batch_no }}</p>
          </div>

          <div class="text-right">
            @if(isset($type) && $type === 'hospital' && isset($upload))
              <p class="text-sm text-gray-600">Type</p>
              <p class="text-sm font-medium text-gray-900">Hospital upload</p>

              <p class="text-sm text-gray-600 mt-2">Hospital</p>
              <p class="text-sm text-gray-800">{{ optional($upload->hospital)->hospital_name ?? '—' }}</p>

              <p class="text-sm text-gray-600 mt-2">Uploader</p>
              <p class="text-sm text-gray-800">{{ optional($upload->uploader)->name ?? optional($upload->uploader)->email ?? '—' }}</p>

              <p class="text-sm text-gray-600 mt-2">Study</p>
              <p class="text-sm text-gray-800">
                {{ optional($upload->fileType)->name ?? '—' }}
                @if(!empty(optional($upload->fileType)->anatomy))
                  ({{ $upload->fileType->anatomy }})
                @endif
              </p>

              <p class="text-sm text-gray-600 mt-2">Urgency</p>
              <p class="text-sm text-gray-800">{{ ucfirst($upload->urgency ?? 'normal') }}</p>

              @if(!empty($upload->clinical_history))
                <p class="text-sm text-gray-600 mt-2">Clinical history</p>
                <p class="text-sm text-gray-800">{{ \Illuminate\Support\Str::limit($upload->clinical_history, 200) }}</p>
              @endif

              <div class="mt-3">
                <a href="{{ route('reader.assignments.download', $batch_no) }}"
                   class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                   Download ZIP
                </a>
              </div>

            @else
              {{-- customer batch (images) --}}
              <p class="text-sm text-gray-600">Type</p>
              <p class="text-sm font-medium text-gray-900">Customer image batch</p>

              <p class="text-sm text-gray-600 mt-2">Download</p>
              <a href="{{ route('reader.assignments.download', $batch_no) }}"
                 class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                 Download ZIP / Files
              </a>

              <p class="text-sm text-gray-600 mt-3">Note</p>
              <p class="text-xs text-gray-500">You will attach findings and optionally upload a PDF report for each assigned image in this batch (system will create a Report row for each assignment).</p>
            @endif
          </div>
        </div>
      </div>

      {{-- Report form --}}
      <form action="{{ route('reader.assignments.report.store', $batch_no) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Findings / Notes</label>
          <textarea name="report_text" rows="8" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter findings, impressions, recommendations...">{{ old('report_text') }}</textarea>
          @error('report_text')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700">Attach PDF report (optional)</label>
          <input type="file" name="report_pdf" accept="application/pdf"
                 class="mt-1 block w-full text-sm" />
          <p class="text-xs text-gray-500 mt-1">Accepted format: PDF. Max ~20 MB.</p>
          @error('report_pdf')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex items-center justify-end space-x-3">
          <a href="{{ route('reader.assignments.index') }}"
             class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-sm">
            Cancel
          </a>

          <button type="submit"
                  class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-sm">
            Submit Report
          </button>
        </div>
      </form>
    </div>
  </div>
</x-read-lay>
