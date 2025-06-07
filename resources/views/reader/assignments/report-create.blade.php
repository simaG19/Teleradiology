<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Submit Report for Batch: {{ $batch_no }}</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow rounded p-6">
        @if($errors->any())
          <div class="mb-4 text-red-600">
            <ul class="list-disc list-inside">
              @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('reader.assignments.report.store', ['batch_no' => $batch_no]) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-4">
            <label class="block text-sm font-medium">Report Text</label>
            <textarea name="report_text" rows="6" required
                      class="mt-1 block w-full border-gray-300 rounded-md">{{ old('report_text') }}</textarea>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Upload PDF (optional)</label>
            <input type="file" name="report_pdf" accept="application/pdf"
                   class="mt-1 block w-full" />
          </div>

          <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
