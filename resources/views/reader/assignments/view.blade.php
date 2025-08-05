<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">View Batch: {{ $batch_no }}</h2>
      <a href="{{ route('reader.assignments.index') }}"
         class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
        ← Back to List
      </a>
    </div>
  </x-slot>

  <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      <iframe
        src="https://meddream.example.com/viewer?studyUID={{ $batch_no }}&serverURL={{ urlencode('https://your-server.com/wado') }}"
        width="100%" height="800" frameborder="0" allowfullscreen>
      </iframe>
    </div>
  </div>
</x-app-layout>
