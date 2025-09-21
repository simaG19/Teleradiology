<!-- resources/views/uploads/success.blade.php -->
<x-user-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12">
        <div class="max-w-md w-full bg-white shadow-lg rounded-xl border border-gray-200 p-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="rounded-full bg-green-100 p-4">
                    <!-- big green check -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="0" class="hidden" />
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-semibold text-gray-800 mb-2">Payment successful</h1>
            <p class="text-sm text-gray-600 mb-6">Your report will be sent soon. Thank you!</p>

            <div class="flex justify-center">
                <a href="{{ url('/uploads') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                    Back to dashboard
                </a>
            </div>
        </div>
    </div>
</x-user-app-layout>
