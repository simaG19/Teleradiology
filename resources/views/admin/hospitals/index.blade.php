<x-admin-lay>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Hospital Management</h2>
            <a href="{{ route('admin.hospitals.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Add New Hospital
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Hospitals Overview</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Hospital Info
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Limits & Usage
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Billing
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($hospitals as $hospital)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $hospital->hospital_name }}</div>
                                            <div class="text-sm text-gray-500">Code: {{ $hospital->hospital_code }}</div>
                                            <div class="text-sm text-gray-500">{{ $hospital->contact_person }}</div>
                                            <div class="text-sm text-gray-500">{{ $hospital->user->email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="text-sm">
                                                <span class="font-medium">Files:</span>
                                                {{ $hospital->current_month_usage }}/{{ $hospital->monthly_file_limit }}
                                                <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                    <div class="bg-blue-600 h-2 rounded-full"
                                                         style="width: {{ min(100, ($hospital->current_month_usage / $hospital->monthly_file_limit) * 100) }}%"></div>
                                                </div>
                                            </div>
                                            <div class="text-sm">
                                                <span class="font-medium">Uploaders:</span>
                                                {{ $hospital->uploaders_count }}/{{ $hospital->uploader_account_limit }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="font-medium">${{ number_format($hospital->monthly_rate, 2) }}/month</div>
                                            <div class="text-gray-500">${{ number_format($hospital->per_file_rate, 2) }}/file</div>
                                            <div class="text-xs text-gray-400">{{ ucfirst($hospital->billing_type) }}</div>
                                            @if($hospital->current_month_bill)
                                                <div class="mt-1 text-xs">
                                                    Current: ${{ number_format($hospital->current_month_bill->total_amount, 2) }}
                                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                                        @if($hospital->current_month_bill->status == 'paid') bg-green-100 text-green-800
                                                        @elseif($hospital->current_month_bill->status == 'overdue') bg-red-100 text-red-800
                                                        @else bg-yellow-100 text-yellow-800 @endif">
                                                        {{ ucfirst($hospital->current_month_bill->status) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($hospital->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                            {{ $hospital->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.hospitals.show', $hospital) }}"
                                               class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                            <a href="{{ route('admin.hospitals.edit', $hospital) }}"
                                               class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                            <form action="{{ route('admin.hospitals.destroy', $hospital) }}"
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this hospital?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No hospitals found. <a href="{{ route('admin.hospitals.create') }}" class="text-blue-600">Create one now</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-lay>
