{{-- resources/views/admin/images/index.blade.php --}}
<x-admin-lay>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-900">All Uploaded Batches</h2>
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                Showing {{ $batches->count() }} batches
            </span>
        </div>
    </x-slot>

    <div class="flex h-full flex-col md:flex-row gap-0 md:gap-6">
        {{-- Sidebar --}}
        <aside class="w-full md:w-64 bg-white border-b md:border-r border-gray-200 hidden md:block rounded-lg shadow-sm">
            @include('admin.sidebar')
        </aside>

        <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">

            <div class="bg-white shadow-lg rounded-lg overflow-hidden animate-fade-in">
                {{-- Filter Form --}}
                <form method="GET" class="border-b border-gray-200 p-4 sm:p-6 bg-gray-50">
                    <div class="flex flex-col sm:flex-row gap-4 mb-4">
                        {{-- Search Input --}}
                        <div class="flex-1 min-w-0">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Batch ID / Uploader">
                        </div>

                        {{-- Urgency Dropdown --}}
                        <div class="flex-1 min-w-0">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Urgency</label>
                            <select name="urgency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                <option value="">All</option>
                                @foreach($urgencyOptions ?? ['Routine','Stat'] as $option)
                                    <option value="{{ $option }}" {{ request('urgency') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Payment Status Dropdown --}}
                        <div class="flex-1 min-w-0">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Payment</label>
                            <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                <option value="">All</option>
                                @foreach(($paymentStatusOptions ?? ['paid','unpaid']) as $option)
                                    <option value="{{ $option }}" {{ request('payment_status') == $option ? 'selected' : '' }}>
                                        {{ ucfirst($option) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                            Filter
                        </button>
                        <a href="{{ route('admin.batches.index') }}" class="w-full sm:w-auto px-6 py-2 text-center bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200">
                            Reset
                        </a>
                    </div>
                </form>

                {{-- Content Area --}}
                <div class="p-4 sm:p-6">
                    @if($batches->isEmpty())
                        <div class="text-center py-16 animate-fade-in">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">No batches found.</p>
                        </div>
                    @else
                        {{-- Desktop Table View --}}
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Batch ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Uploaded At</th>
                                        {{-- <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Files</th> --}}
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Urgency</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type (Anatomy)</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Payment Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($batches as $batch)
                                        <tr class="hover:bg-blue-50 transition-colors duration-200 animate-fade-in">
                                            {{-- Batch ID --}}
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                {{ $batch->id }}
                                            </td>

                                            {{-- Uploaded At --}}
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                {{ optional($batch->created_at)->format('Y-m-d H:i') ?? '—' }}
                                            </td>

                                            {{-- Files Count --}}
                                            {{-- <td class="px-6 py-4 text-sm text-gray-700">
                                                @php
                                                    $filesCount = $batch->images_count ?? (method_exists($batch, 'images') ? $batch->images()->count() : 0);
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-medium">
                                                    {{ $filesCount }} {{ $filesCount == 1 ? 'file' : 'files' }}
                                                </span>
                                            </td> --}}

                                            {{-- Urgency --}}
                                            <td class="px-6 py-4 text-sm">
                                                @if(optional($batch)->urgency === 'urgent')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-xs animate-pulse">Urgent</span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs">Normal</span>
                                                @endif
                                            </td>

                                            {{-- Type + Anatomy --}}
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                @if(optional($batch->fileType)->name)
                                                    <div>
                                                        <p class="font-medium">{{ $batch->fileType->name }}</p>
                                                        @if(!empty($batch->fileType->anatomy))
                                                            <p class="text-xs text-gray-500">{{ $batch->fileType->anatomy }}</p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>

                                            {{-- Price --}}
                                            <td class="px-6 py-4 text-sm font-medium">
                                                @if(is_null($batch->quoted_price))
                                                    <span class="text-gray-500">TBD</span>
                                                @else
                                                    <span class="text-gray-900">{{ number_format($batch->quoted_price, 2) }} birr</span>
                                                @endif
                                            </td>

                                            {{-- Payment Status --}}
                                            <td class="px-6 py-4 text-sm">
                                                @if(optional($batch)->paid === 0)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-xs">Unpaid</span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs">Paid</span>
                                                @endif
                                            </td>

                                            {{-- Actions --}}
                                            <td class="px-6 py-4 text-center text-sm font-medium space-x-2">
                                                <div class="flex gap-2 justify-center">
                                                    @if(is_null($batch->status) || $batch->status !== 'assigned')
                                                        <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->id]) }}"
                                                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                                                            Assign
                                                        </a>
                                                    @elseif($batch->status === 'assigned')
                                                        <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->id]) }}"
                                                           class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                                                            Reassign
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('admin.batches.download', $batch) }}"
                                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95">
                                                        Download
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Card View --}}
                        <div class="lg:hidden space-y-4">
                            @foreach($batches as $batch)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200 animate-fade-in bg-white">
                                    {{-- Header --}}
                                    <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-200">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900">{{ $batch->id }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ optional($batch->created_at)->format('Y-m-d H:i') ?? '—' }}</p>
                                        </div>
                                        @if(optional($batch)->paid === 0)
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 font-semibold text-xs">Unpaid</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold text-xs">Paid</span>
                                        @endif
                                    </div>

                                    {{-- Details Grid --}}
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Files</p>
                                            @php $filesCount = $batch->images_count ?? (method_exists($batch, 'images') ? $batch->images()->count() : 0); @endphp
                                            <p class="text-lg font-bold text-gray-900">{{ $filesCount }}</p>
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Urgency</p>
                                            @if(optional($batch)->urgency === 'urgent')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-red-800 font-semibold text-xs bg-red-100">Urgent</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded text-green-800 font-semibold text-xs bg-green-100">Normal</span>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Price</p>
                                            @if(is_null($batch->quoted_price))
                                                <p class="text-lg font-bold text-gray-500">TBD</p>
                                            @else
                                                <p class="text-lg font-bold text-gray-900">{{ number_format($batch->quoted_price, 2) }} birr</p>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold uppercase mb-1">Type</p>
                                            @if(optional($batch->fileType)->name)
                                                <p class="text-sm font-medium text-gray-900">{{ $batch->fileType->name }}</p>
                                            @else
                                                <p class="text-sm text-gray-400">—</p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="pt-4 border-t border-gray-200 space-y-2">
                                        <div class="flex gap-2">
                                            @if(is_null($batch->status) || $batch->status !== 'assigned')
                                                <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->id]) }}"
                                                   class="flex-1 px-3 py-2 bg-indigo-600 text-white font-medium text-center rounded-lg hover:bg-indigo-700 transition-all duration-200 active:scale-95">
                                                    Assign
                                                </a>
                                            @elseif($batch->status === 'assigned')
                                                <a href="{{ route('admin.assign.reader', ['batch_no' => $batch->id]) }}"
                                                   class="flex-1 px-3 py-2 bg-yellow-600 text-white font-medium text-center rounded-lg hover:bg-yellow-700 transition-all duration-200 active:scale-95">
                                                    Reassign
                                                </a>
                                            @endif

                                            <a href="{{ route('admin.batches.download', $batch) }}"
                                               class="flex-1 px-3 py-2 bg-blue-600 text-white font-medium text-center rounded-lg hover:bg-blue-700 transition-all duration-200 active:scale-95">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    {{-- Animations --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @media (max-width: 768px) {
            .animate-fade-in {
                animation-delay: calc(var(--index, 0) * 50ms);
            }
        }
    </style>
</x-admin-lay>
