<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold">Billing for {{ $user->name }}</h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
      {{-- Summary --}}
      <div class="bg-white shadow rounded p-6 flex justify-between">
        <div>
          <p class="text-lg">Total Files:</p>
          <p class="text-2xl font-bold">{{ $count }}</p>
        </div>
        <div>
          <p class="text-lg">Rate per File:</p>
          <p class="text-2xl font-bold">${{ number_format($profile->billing_rate, 2) }}</p>
        </div>
        
      </div>

      {{-- Detail Table --}}
      <div class="bg-white shadow rounded p-6">
        <h3 class="text-lg font-medium mb-4">Uploads Detail</h3>
        @if($uploads->isEmpty())
          <p>No uploads this period.</p>
        @else
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-left">Filename</th>
                <th class="px-4 py-2 text-left">Uploaded At</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($uploads as $img)
                <tr>
                  <td class="px-4 py-2">{{ $img->original_name }}</td>
                  <td class="px-4 py-2">{{ $img->created_at->format('Y-m-d H:i') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
