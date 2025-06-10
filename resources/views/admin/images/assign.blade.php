{{-- resources/views/admin/images/assign.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Assign Reader for Batch: {{ $batch_no }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Show validation errors at top --}}
                @if($errors->any())
                    <div class="mb-4">
                        <ul class="list-disc list-inside text-red-600">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- The form --}}
                <form action="{{ route('admin.images.assign.store', $batch_no) }}" method="POST">
                    @csrf

                    {{-- Batch (read-only) --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Batch Number</label>
                        <input
                            type="text"
                            value="{{ $batch_no }}"
                            disabled
                            class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md"
                        />
                    </div>

                    {{-- Reader Dropdown --}}
                    <div class="mb-4">
                        <label for="reader_id" class="block text-sm font-medium text-gray-700">
                            Select Reader
                        </label>
                        <select
                            name="reader_id"
                            id="reader_id"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md"
                        >
                            <option value="">-- Choose a reader --</option>
                            @foreach($readers as $reader)
                                <option value="{{ $reader->id }}"
                                    {{ old('reader_id') == $reader->id ? 'selected' : '' }}>
                                    {{ $reader->name }} ({{ $reader->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Deadline (date + time) --}}
                    <div class="mb-4">
                        <label for="deadline" class="block text-sm font-medium text-gray-700">
                            Deadline (YYYY-MM-DD HH:MM)
                        </label>
                        <input
                            type="datetime-local"
                            name="deadline"
                            id="deadline"
                            value="{{ old('deadline') }}"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md"
                        />
                    </div>

                    {{-- Submit button --}}
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                        >
                            Assign Reader
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
