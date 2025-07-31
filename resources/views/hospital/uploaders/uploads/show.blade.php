<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="text-xl font-semibold">Batch: {{ $image->batch_no }}</h2>
      <a href="{{ route('uploader.dashboard') }}"
         class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
        ← Back
      </a>
    </div>
  </x-slot>

  <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6 mb-6">
      <p><strong>Original Filename:</strong> {{ $image->original_name }}</p>
      <p><strong>Uploaded At:</strong> {{ $image->created_at->format('Y-m-d H:i') }}</p>
      <p><strong>Stored Filename:</strong> {{ $image->filename }}</p>
    </div>

    <div class="bg-white shadow rounded p-6">
      <h3 class="text-lg font-medium mb-4">Report</h3>
      @if($image->report)
        <a href="{{ Storage::url($image->report->pdf_path) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
           target="_blank">
          Download PDF Report
        </a>
        <p class="mt-4 whitespace-pre-wrap">{{ $image->report->report_text }}</p>
      @else
        <p class="text-gray-600">No report has been submitted yet.</p>
      @endif
    </div>
  </div>
</x-app-layout>
