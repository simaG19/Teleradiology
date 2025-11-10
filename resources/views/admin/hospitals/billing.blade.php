<x-admin-lay>
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
          <p class="text-lg">Total Bill</p>
          <p class="text-2xl font-bold">{{ number_format($profile->billing_rate, 2) }} ETB</p>
        </div>
        
      </div>

      {{-- Detail Table --}}
<div class="bg-white shadow rounded p-6">
  <h3 class="text-lg font-medium mb-4">Uploads Detail</h3>
  @if($lines->isEmpty())
    <p>No uploads this period.</p>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Batch</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Price (birr)</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach($lines as $line)
            <tr>
              <td class="px-4 py-3 text-sm text-gray-700">
                <div class="font-medium">{{ $line->batch_id }}</div>
                <div class="text-xs text-gray-400">{{ $line->source === 'hospital' ? 'Hospital ZIP' : 'Customer batch' }}</div>
              </td>

              <td class="px-4 py-3 text-sm text-gray-700">
                {{ \Carbon\Carbon::parse($line->date)->format('Y-m-d H:i') }}
              </td>

              <td class="px-4 py-3 text-sm text-gray-700">
                @if($line->file_type_name)
                  {{ $line->file_type_name }}
                  @if(!empty($line->file_type_anatomy))
                    ({{ $line->file_type_anatomy }})
                  @endif
                @else
                  <span class="text-gray-500">—</span>
                @endif
              </td>

              <td class="px-4 py-3 text-sm text-gray-700 text-right">
                {{ number_format($line->price, 2) }}
              </td>
            </tr>
          @endforeach
        </tbody>

        <tfoot class="bg-gray-50">
          <tr>
            <td colspan="2" class="px-4 py-3 text-sm font-medium text-gray-700">Totals</td>
            <td class="px-4 py-3 text-sm font-medium text-gray-700">{{ $count }} batches</td>
            <td class="px-4 py-3 text-sm font-medium text-gray-700 text-right">{{ number_format($bill,2) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  @endif
</div>

    </div>
  </div>
</x-admin-lay>
