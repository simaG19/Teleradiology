<x-app-layout>
    <x-slot name="header">
        <div class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-500 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Assign Reader</h1>
                        <p class="text-sm text-gray-500">Batch: <span class="font-medium text-gray-700">{{ $batch_no }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <div class="bg-blue-500 rounded-full p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-700">Batch Uploaded</span>
                    </div>
                    <div class="w-16 h-1 bg-blue-500 rounded"></div>
                    <div class="flex items-center">
                        <div class="bg-green-500 rounded-full p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Assign Reader</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-300 rounded"></div>
                    <div class="flex items-center">
                        <div class="bg-gray-300 rounded-full p-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Review & Report</span>
                    </div>
                </div>
            </div>

            <!-- Main Assignment Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Reader Assignment Form
                        </h2>
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                            Batch {{ $batch_no }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.images.assign.store', $batch_no) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Batch Information Section -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Batch Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Batch Number
                                    </label>
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value="{{ $batch_no }}"
                                            disabled
                                            class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-700 font-medium"
                                        />
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Assignment Status
                                    </label>
                                    <div class="flex items-center px-4 py-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-yellow-800 font-medium">Pending Assignment</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reader Selection Section -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Reader Selection</h3>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <label for="reader_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Radiologist <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select
                                        name="reader_id"
                                        id="reader_id"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none bg-white"
                                    >
                                        <option value="">-- Choose a radiologist --</option>
                                        @foreach($readers as $reader)
                                            <option value="{{ $reader->id }}"
                                                {{ old('reader_id') == $reader->id ? 'selected' : '' }}>
                                                {{ $reader->name }} ({{ $reader->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Select the radiologist who will review this batch</p>
                            </div>

                            <!-- Reader Info Card (Dynamic) -->
                            <div id="reader-info" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-blue-900" id="selected-reader-name">Selected Reader</h4>
                                        <p class="text-sm text-blue-700" id="selected-reader-email">Email will appear here</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deadline Section -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Deadline Settings</h3>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                    Review Deadline <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        type="datetime-local"
                                        name="deadline"
                                        id="deadline"
                                        value="{{ old('deadline') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v16a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Set the deadline for completing the radiology review</p>
                            </div>

                            <!-- Quick Deadline Options -->
                            <div class="bg-blue-50 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Quick Options
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                    <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="setDeadline(24)">
                                        24 Hours
                                    </button>
                                    <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="setDeadline(48)">
                                        48 Hours
                                    </button>
                                    <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="setDeadline(72)">
                                        3 Days
                                    </button>
                                    <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="setDeadline(168)">
                                        1 Week
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.images.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Batches
                            </a>

                            <div class="flex space-x-3">
                                <button type="button"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview
                                </button>

                                <button type="submit"
                                        class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Assign Reader
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for enhanced functionality -->
    <script>
        // Reader selection handler
        document.getElementById('reader_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const readerInfo = document.getElementById('reader-info');
            const readerName = document.getElementById('selected-reader-name');
            const readerEmail = document.getElementById('selected-reader-email');

            if (this.value) {
                const text = selectedOption.text;
                const name = text.split(' (')[0];
                const email = text.match(/$$([^)]+)$$/)[1];

                readerName.textContent = name;
                readerEmail.textContent = email;
                readerInfo.classList.remove('hidden');
            } else {
                readerInfo.classList.add('hidden');
            }
        });

        // Quick deadline setter
        function setDeadline(hours) {
            const now = new Date();
            now.setHours(now.getHours() + hours);

            // Format for datetime-local input
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hour = String(now.getHours()).padStart(2, '0');
            const minute = String(now.getMinutes()).padStart(2, '0');

            const formattedDateTime = `${year}-${month}-${day}T${hour}:${minute}`;
            document.getElementById('deadline').value = formattedDateTime;
        }

        // Set default deadline to 48 hours from now
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.getElementById('deadline').value) {
                setDeadline(48);
            }
        });
    </script>
</x-app-layout>
