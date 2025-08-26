{{-- resources/views/uploads/create.blade.php --}}
<x-user-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Upload DICOM Archive</h2>
                <p class="text-sm text-gray-600">Upload medical imaging files for radiological analysis</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Upload Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h3 class="text-xl font-semibold text-white">Medical Image Upload</h3>
                    <p class="text-blue-100 mt-1">Please provide the required information and select your DICOM archive</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="uploadForm" action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Urgency -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        <svg class="w-4 h-4 inline mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                                        </svg>
                                        Priority Level
                                    </label>
                                    <select name="urgency" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-white" required>
                                        <option value="normal" {{ old('urgency')=='normal' ? 'selected':'' }}>
                                            🟢 Normal Priority (24 hours)
                                        </option>
                                        <option value="urgent" {{ old('urgency')=='urgent' ? 'selected':'' }}>
                                            🔴 Urgent Priority (4 hours)
                                        </option>
                                    </select>
                                    @error('urgency')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>


                                <div class="mb-4">
          <label class="block text-sm font-medium">File Type</label>
          <select name="file_type_id" required class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">— select file type —</option>
            @foreach(\App\Models\FileType::orderBy('name')->get() as $type)
              <option value="{{ $type->id }}" {{ old('file_type_id') == $type->id ? 'selected' : '' }}>
                {{ $type->name }} {{ $type->anatomy ? '— '.$type->anatomy : '' }} — {{ number_format($type->price_per_file,2) }} birr/file
              </option>
            @endforeach
          </select>
          @error('file_type_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>


                                <!-- Clinical History -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        <svg class="w-4 h-4 inline mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Clinical History
                                        <span class="text-gray-500 font-normal">(optional)</span>
                                    </label>
                                    <textarea name="clinical_history" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 resize-none"
                                        placeholder="Please provide relevant clinical history, symptoms, or specific areas of concern...">{{ old('clinical_history') }}</textarea>
                                    @error('clinical_history')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- File Upload -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        <svg class="w-4 h-4 inline mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        DICOM Archive File
                                    </label>

                                    <!-- File Drop Zone -->
                                    <div id="dropzone" class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition duration-200 bg-gray-50 hover:bg-blue-50">
                                        <input type="file" name="archive" accept=".zip" required id="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />

                                        <div id="dropzoneContent">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-700 mb-2">Drop your ZIP file here</p>
                                            <p class="text-sm text-gray-500 mb-4">or click to browse</p>
                                            <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Select File
                                            </div>
                                        </div>

                                        <!-- Selected File Display -->
                                        <div id="selectedFile" class="hidden">
                                            <div class="flex items-center justify-center space-x-3">
                                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
                                                </svg>
                                                <div>
                                                    <p id="fileName" class="font-medium text-gray-900"></p>
                                                    <p id="fileSize" class="text-sm text-gray-500"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @error('archive')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Upload Guidelines -->
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                    <h4 class="font-semibold text-blue-900 mb-2">Upload Guidelines</h4>
                                    <ul class="text-sm text-blue-800 space-y-1">
                                        <li>• Maximum file size: 500MB</li>
                                        <li>• Accepted format: ZIP archives only</li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Bar (Hidden by default) -->
                        <div id="progressContainer" class="hidden mt-8">
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Uploading...</span>
                                    <span id="progressPercent" class="text-sm font-medium text-blue-600">0%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                                </div>
                                <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                                    <span id="uploadSpeed">Calculating speed...</span>
                                    <span id="timeRemaining">Calculating time...</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span id="submitText">Upload DICOM Archive</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <p class="text-green-800 text-sm">
                        <strong>Secure Upload:</strong> All files are encrypted during transmission and stored securely in compliance with HIPAA regulations.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for file handling and progress -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const dropzone = document.getElementById('dropzone');
            const dropzoneContent = document.getElementById('dropzoneContent');
            const selectedFile = document.getElementById('selectedFile');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const form = document.getElementById('uploadForm');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressPercent = document.getElementById('progressPercent');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const uploadSpeed = document.getElementById('uploadSpeed');
            const timeRemaining = document.getElementById('timeRemaining');

            // File size formatter
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    dropzoneContent.classList.add('hidden');
                    selectedFile.classList.remove('hidden');
                    dropzone.classList.add('border-green-400', 'bg-green-50');
                    dropzone.classList.remove('border-gray-300', 'bg-gray-50');
                }
            });

            // Drag and drop functionality
            dropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropzone.classList.add('border-blue-400', 'bg-blue-50');
            });

            dropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropzone.classList.remove('border-blue-400', 'bg-blue-50');
            });

            dropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropzone.classList.remove('border-blue-400', 'bg-blue-50');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    const event = new Event('change', { bubbles: true });
                    fileInput.dispatchEvent(event);
                }
            });

            // Form submission with progress
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();

                let startTime = Date.now();
                let startLoaded = 0;

                // Show progress container
                progressContainer.classList.remove('hidden');
                submitBtn.disabled = true;
                submitText.textContent = 'Uploading...';

                // Upload progress
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        progressBar.style.width = percentComplete + '%';
                        progressPercent.textContent = Math.round(percentComplete) + '%';

                        // Calculate speed and time remaining
                        const currentTime = Date.now();
                        const elapsedTime = (currentTime - startTime) / 1000; // seconds
                        const loadedSinceStart = e.loaded - startLoaded;

                        if (elapsedTime > 1) {
                            const speed = loadedSinceStart / elapsedTime; // bytes per second
                            const remaining = (e.total - e.loaded) / speed; // seconds remaining

                            uploadSpeed.textContent = formatFileSize(speed) + '/s';

                            if (remaining > 60) {
                                timeRemaining.textContent = Math.round(remaining / 60) + ' min remaining';
                            } else {
                                timeRemaining.textContent = Math.round(remaining) + ' sec remaining';
                            }
                        }
                    }
                });

                // Handle completion
                xhr.addEventListener('load', function() {
                    if (xhr.status === 200) {
                        progressBar.style.width = '100%';
                        progressPercent.textContent = '100%';
                        submitText.textContent = 'Upload Complete!';

                        // Redirect or show success message
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    } else {
                        // Handle error
                        progressContainer.classList.add('hidden');
                        submitBtn.disabled = false;
                        submitText.textContent = 'Upload DICOM Archive';
                        alert('Upload failed. Please try again.');
                    }
                });

                // Handle error
                xhr.addEventListener('error', function() {
                    progressContainer.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitText.textContent = 'Upload DICOM Archive';
                    alert('Upload failed. Please check your connection and try again.');
                });

                // Send the request
                xhr.open('POST', form.action);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                xhr.send(formData);
            });
        });
    </script>
</x-user-app-layout>
