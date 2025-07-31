<x-app-layout>
  <x-slot name="header">
    <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center space-x-3">
          <div class="bg-green-500 p-2 rounded-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-900">Submit Radiology Report</h1>
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
            <span class="ml-2 text-sm font-medium text-gray-700">Review Images</span>
          </div>
          <div class="w-16 h-1 bg-blue-500 rounded"></div>
          <div class="flex items-center">
            <div class="bg-green-500 rounded-full p-2">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
              </svg>
            </div>
            <span class="ml-2 text-sm font-medium text-green-600">Create Report</span>
          </div>
          <div class="w-16 h-1 bg-gray-300 rounded"></div>
          <div class="flex items-center">
            <div class="bg-gray-300 rounded-full p-2">
              <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
              </svg>
            </div>
            <span class="ml-2 text-sm font-medium text-gray-500">Submit</span>
          </div>
        </div>
      </div>

      <!-- Main Form Card -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
              <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Radiology Report Form
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
                      @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          @endif

          <form action="{{ route('reader.assignments.report.store', ['batch_no' => $batch_no]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Report Text Section -->
            <div class="space-y-4">
              <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Clinical Findings & Interpretation</h3>
              </div>

              <div class="bg-gray-50 rounded-lg p-4">
                <label for="report_text" class="block text-sm font-medium text-gray-700 mb-2">
                  Radiology Report <span class="text-red-500">*</span>
                </label>
                <textarea
                  id="report_text"
                  name="report_text"
                  rows="8"
                  required
                  placeholder="Enter your detailed radiology findings, impressions, and recommendations here..."
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none">{{ old('report_text') }}</textarea>
                <div class="mt-2 flex justify-between items-center">
                  <p class="text-sm text-gray-500">Provide detailed findings and clinical impressions</p>
                  <span class="text-xs text-gray-400" id="char-count">0 characters</span>
                </div>
              </div>
            </div>

            <!-- Quick Templates -->
            <div class="bg-blue-50 rounded-lg p-4">
              <h4 class="text-sm font-medium text-blue-900 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Quick Templates
              </h4>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="insertTemplate('normal')">
                  Normal Study
                </button>
                <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="insertTemplate('abnormal')">
                  Abnormal Findings
                </button>
                <button type="button" class="text-left px-3 py-2 text-sm bg-white border border-blue-200 rounded-md hover:bg-blue-100 transition-colors duration-150" onclick="insertTemplate('followup')">
                  Follow-up Required
                </button>
              </div>
            </div>

            <!-- File Upload Section -->
            <div class="space-y-4">
              <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Additional Documentation</h3>
              </div>

              <div class="bg-gray-50 rounded-lg p-4">
                <label for="report_pdf" class="block text-sm font-medium text-gray-700 mb-2">
                  Upload PDF Report (Optional)
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors duration-200">
                  <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                      <label for="report_pdf" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                        <span>Upload a PDF file</span>
                        <input id="report_pdf" name="report_pdf" type="file" accept="application/pdf" class="sr-only">
                      </label>
                      <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PDF up to 10MB</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <a href="{{ route('reader.assignments.index') }}"
                 class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Assignments
              </a>

              <div class="flex space-x-3">
                <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-150">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                  </svg>
                  Save Draft
                </button>

                <button type="submit"
                        class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-150 shadow-lg hover:shadow-xl">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                  </svg>
                  Submit Report
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
    // Character counter
    const textarea = document.getElementById('report_text');
    const charCount = document.getElementById('char-count');

    textarea.addEventListener('input', function() {
      charCount.textContent = this.value.length + ' characters';
    });

    // Template insertion
    function insertTemplate(type) {
      const textarea = document.getElementById('report_text');
      let template = '';

      switch(type) {
        case 'normal':
          template = 'FINDINGS:\nNo acute abnormalities identified.\n\nIMPRESSION:\nNormal study.\n\nRECOMMENDATIONS:\nNo further imaging required at this time.';
          break;
        case 'abnormal':
          template = 'FINDINGS:\n[Describe abnormal findings here]\n\nIMPRESSION:\n[Clinical impression based on findings]\n\nRECOMMENDATIONS:\n[Recommended follow-up or additional studies]';
          break;
        case 'followup':
          template = 'FINDINGS:\n[Current findings]\n\nIMPRESSION:\n[Clinical assessment]\n\nRECOMMENDATIONS:\nFollow-up imaging recommended in [timeframe] to assess [specific concern].';
          break;
      }

      textarea.value = template;
      textarea.focus();
      charCount.textContent = template.length + ' characters';
    }

    // File upload feedback
    document.getElementById('report_pdf').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        console.log(`File selected: ${file.name} (${fileSize} MB)`);
      }
    });
  </script>
</x-app-layout>
