{{-- resources/views/admin/images/assign.blade.php --}}
<x-admin-lay>
  <x-slot name="header">
    <h2 class="text-2xl font-bold text-gray-900">Assign Reader</h2>
  </x-slot>

  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
      <!-- Main Card Container -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl">

        @php
          // determine presented batch id for form route
          if (isset($type) && $type === 'hospital') {
              $form_batch = $upload->id;
              $displayLabel = "Hospital upload: {$upload->id}";
          } elseif (isset($type) && $type === 'batch') {
              $form_batch = $batchModel->id;
              $displayLabel = "Batch: {$batchModel->id}";
          } else {
              $form_batch = $batch_no ?? null;
              $displayLabel = "Batch: {$batch_no}";
          }
        @endphp

        <div class="p-8">
          <!-- Header Section -->
          <div class="mb-8 animate-fadeIn">
            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Batch Assignment</h3>
            <p class="text-lg font-medium text-gray-900">
              {{ $displayLabel }}
            </p>
            <div class="mt-4 h-1 w-16 bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full"></div>
          </div>

          <!-- Error State -->
          @if (! $form_batch)
            <div class="animate-slideInDown">
              <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>Invalid batch. Cannot show assign form.</span>
              </div>
            </div>
          @else
            <!-- Form Section -->
            <form action="{{ route('admin.images.assign.store', ['batch_no' => $form_batch]) }}" method="POST" class="animate-slideInUp space-y-6">
              @csrf

              <!-- Reader Selection -->
              <div class="group">
                <label for="reader_id" class="block text-sm font-semibold text-gray-700 mb-2">
                  Assign To (Reader)
                  <span class="text-red-500">*</span>
                </label>
                <select
                  id="reader_id"
                  name="reader_id"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 bg-white text-gray-900 appearance-none cursor-pointer"
                  style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3e%3cpolyline points=%226 9 12 15 18 9%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.5em 1.5em; padding-right: 2.5rem;"
                >
                  <option value="">— Select a reader —</option>
                  @foreach($readers as $r)
                    <option value="{{ $r->id }}" class="py-2">
                      {{ $r->name }} — {{ $r->email }}
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Deadline Input -->
              <div class="group">
                <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                  Deadline
                  <span class="text-red-500">*</span>
                </label>
                <input
                  type="datetime-local"
                  id="deadline"
                  name="deadline"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-400 text-gray-900"
                >
              </div>

              <!-- Submit Button -->
              <div class="flex justify-end gap-3 pt-4">
                <a
                  href="javascript:history.back()"
                  class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105 active:scale-95"
                >
                  Cancel
                </a>
                <button
                  type="submit"
                  class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Assign
                  </span>
                </button>
              </div>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Animations -->
  <style>
    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes slideInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fadeIn {
      animation: fadeIn 0.5s ease-in-out;
    }

    .animate-slideInUp {
      animation: slideInUp 0.5s ease-out 0.2s both;
    }

    .animate-slideInDown {
      animation: slideInDown 0.5s ease-out;
    }

    /* Smooth transitions for interactive elements */
    input:focus,
    select:focus {
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  </style>
</x-admin-lay>
