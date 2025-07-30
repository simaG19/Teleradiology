{{-- resources/views/uploads/index.blade.php --}}
<x-user-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">My Uploads</h2>
      <a href="{{ route('uploads.create') }}"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Send New File
      </a>
    </div>
  </x-slot>

  <div class="py-8 max-w-4xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded p-6">
      @if($batches->isEmpty())
        <p class="text-gray-600">You haven’t uploaded any files yet.</p>
      @else
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batch No.</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uploaded At</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urgency</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">price</th>
               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pay</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($batches as $batch)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $batch->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ $batch->created_at->format('Y-m-d H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  @if($batch->urgency === 'urgent')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                      Urgent (4 hrs)
                    </span>
                  @else
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                      Normal (24 hrs)
                    </span>
                  @endif
                </td>

<td class="px-6 py-4 whitespace-nowrap text-sm">
  {{ optional($batch->fileType)->name ?? '—' }}
</td>
<td class="px-6 py-4 whitespace-nowrap text-sm">
  @if($batch->fileType)
    {{ number_format($batch->fileType->price_per_file,2) }} birr
  @else
    —
  @endif
</td>


       {{-- new Pay button --}}
      <td class="px-6 py-4 whitespace-nowrap">
        @if(!is_null($batch->quoted_price))
          <a href="{{ route('uploads.pay.form', $batch->id) }}"
             class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
            Pay
          </a>
        @else
          <span class="text-gray-400">—</span>
        @endif
      </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</x-user-app-layout>
