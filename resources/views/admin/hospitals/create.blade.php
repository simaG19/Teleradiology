<x-admin-lay>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Create New Hospital</h2>
            <a href="{{ route('admin.hospitals.index') }}"
               class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                Back to Hospitals
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Hospital Information</h3>
                </div>

                <form action="{{ route('admin.hospitals.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hospital Details -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-900">Hospital Details</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hospital Name</label>
                                <input type="text" name="hospital_name" value="{{ old('hospital_name') }}" required
                                       class="w-full border-gray-300 rounded-md">
                                @error('hospital_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hospital Code</label>
                                <input type="text" name="hospital_code" value="{{ old('hospital_code') }}" required
                                       class="w-full border-gray-300 rounded-md">
                                @error('hospital_code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                                <input type="text" name="contact_person" value="{{ old('contact_person') }}" required
                                       class="w-full border-gray-300 rounded-md">
                                @error('contact_person')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="w-full border-gray-300 rounded-md">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="w-full border-gray-300 rounded-md">
                                @error('phone')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="address" rows="3" class="w-full border-gray-300 rounded-md">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Limits & Billing -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-900">Limits & Billing</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monthly File Limit</label>
                                <input type="number" name="monthly_file_limit" value="{{ old('monthly_file_limit', 100) }}" required min="1"
                                       class="w-full border-gray-300 rounded-md">
                                @error('monthly_file_limit')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Uploader Account Limit</label>
                                <input type="number" name="uploader_account_limit" value="{{ old('uploader_account_limit', 5) }}" required min="1"
                                       class="w-full border-gray-300 rounded-md">
                                @error('uploader_account_limit')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Billing Type</label>
                                <select name="billing_type" required class="w-full border-gray-300 rounded-md">
                                    <option value="monthly" {{ old('billing_type') == 'monthly' ? 'selected' : '' }}>Monthly Only</option>
                                    <option value="per_file" {{ old('billing_type') == 'per_file' ? 'selected' : '' }}>Per File Only</option>
                                    <option value="both" {{ old('billing_type') == 'both' ? 'selected' : '' }}>Monthly + Per File</option>
                                </select>
                                @error('billing_type')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Rate ($)</label>
                                <input type="number" name="monthly_rate" value="{{ old('monthly_rate', 0) }}" required min="0" step="0.01"
                                       class="w-full border-gray-300 rounded-md">
                                @error('monthly_rate')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Per File Rate ($)</label>
                                <input type="number" name="per_file_rate" value="{{ old('per_file_rate', 0) }}" required min="0" step="0.01"
                                       class="w-full border-gray-300 rounded-md">
                                @error('per_file_rate')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contract Start Date</label>
                                <input type="date" name="contract_start_date" value="{{ old('contract_start_date') }}"
                                       class="w-full border-gray-300 rounded-md">
                                @error('contract_start_date')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contract End Date</label>
                                <input type="date" name="contract_end_date" value="{{ old('contract_end_date') }}"
                                       class="w-full border-gray-300 rounded-md">
                                @error('contract_end_date')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('admin.hospitals.index') }}"
                           class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Create Hospital
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-lay>
