{{-- resources/views/uploads/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Upload DICOM ZIP Archive</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto bg-white p-6 shadow rounded">
            @if(session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium">
                        Choose ZIP of DICOM files:
                    </label>
                    <input
                        type="file"
                        name="archive"
                        accept=".zip"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md"
                    />
                    @error('archive')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Upload
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
