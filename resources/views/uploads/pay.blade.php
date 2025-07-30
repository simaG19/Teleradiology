{{-- resources/views/uploads/pay.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Payment for Batch #{{ $batch->id }}</h2>
                <p class="text-sm text-gray-600">Complete your payment to process your DICOM files</p>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Payment Summary Card -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl border border-gray-200 p-4 sm:p-8 mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex-1">
                        <div class="flex items-center mb-4">
                            <div class="p-2 sm:p-3 bg-green-100 rounded-lg sm:rounded-xl mr-3 sm:mr-4">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-semibold text-gray-600">Total Amount Due</h3>
                                <p class="text-xs sm:text-sm text-gray-500">Batch ID: #{{ $batch->id }}</p>
                            </div>
                        </div>
                      <div class="mb-6 space-y-2">
  <p class="text-gray-700"><strong>File Type:</strong>
    {{ optional($batch->fileType)->name ?? '—' }}
  </p>
  {{-- <p class="text-gray-700"><strong>Unit Price:</strong> --}}
    {{-- @if($batch->fileType)
      {{ number_format($batch->fileType->price_per_file,2) }} birr/file
    @else
      —
    @endif --}}
  {{-- </p> --}}
  {{-- <p class="text-gray-700"><strong>Files in Batch:</strong>
    {{ $batch->images->count() }}
  </p> --}}
  <p class="text-gray-700"><strong>Total Amount Due:</strong>
    <span class="text-2xl text-green-600">
     {{ number_format($batch->fileType->price_per_file,2) }}birr
    </span>
  </p>
  @if($batch->clinical_history)
    <p class="text-gray-700"><strong>Clinical History:</strong><br>
      <em>{{ $batch->clinical_history }}</em>
    </p>
  @endif
</div>

                    </div>
                    <div class="text-center sm:text-right">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl sm:rounded-2xl p-4 sm:p-6 text-white shadow-lg">
                            <svg class="w-8 h-8 sm:w-12 sm:h-12 mx-auto mb-2 sm:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs sm:text-sm font-medium">Ready to Pay</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 text-xs sm:text-sm">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-gray-600">Secure Payment</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="text-gray-600">Instant Processing</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-gray-600">HIPAA Compliant</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gray-50 px-4 sm:px-8 py-4 sm:py-6 border-b border-gray-200">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900">Choose Payment Method</h3>
                    <p class="text-gray-600 mt-1 text-sm sm:text-base">Select your preferred payment option below</p>
                </div>

                <div class="p-4 sm:p-8">
                    <form id="paymentForm" action="#" method="POST">
                        @csrf

                        <!-- Payment Method Selection -->
                        <div class="mb-6 sm:mb-8">
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                                <!-- Card Payment -->
                                <div class="payment-option" data-method="card_payment">
                                    <input type="radio" id="card_payment" name="payment_method" value="card_payment" class="sr-only" {{ old('payment_method') == 'card_payment' ? 'checked' : '' }}>
                                    <label for="card_payment" class="payment-card cursor-pointer block p-3 sm:p-6 border-2 border-gray-200 rounded-lg sm:rounded-xl hover:border-blue-400 transition duration-200">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-16 sm:h-16 mx-auto mb-2 sm:mb-4 bg-blue-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                                                <svg class="w-5 h-5 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Card Payment</h4>
                                            <p class="text-xs sm:text-sm text-gray-500">Visa, Mastercard</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Chapa -->
                                <div class="payment-option" data-method="chapa">
                                    <input type="radio" id="chapa" name="payment_method" value="chapa" class="sr-only" {{ old('payment_method') == 'chapa' ? 'checked' : '' }}>
                                    <label for="chapa" class="payment-card cursor-pointer block p-3 sm:p-6 border-2 border-gray-200 rounded-lg sm:rounded-xl hover:border-orange-400 transition duration-200">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-16 sm:h-16 mx-auto mb-2 sm:mb-4 bg-orange-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                                                <div class="w-5 h-5 sm:w-8 sm:h-8 bg-orange-600 rounded flex items-center justify-center">
                                                    <span class="text-white font-bold text-xs sm:text-sm">CH</span>
                                                </div>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Chapa</h4>
                                            <p class="text-xs sm:text-sm text-gray-500">Digital Payment</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Telebirr -->
                                <div class="payment-option" data-method="telebirr">
                                    <input type="radio" id="telebirr" name="payment_method" value="telebirr" class="sr-only" {{ old('payment_method') == 'telebirr' ? 'checked' : '' }}>
                                    <label for="telebirr" class="payment-card cursor-pointer block p-3 sm:p-6 border-2 border-gray-200 rounded-lg sm:rounded-xl hover:border-yellow-400 transition duration-200">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-16 sm:h-16 mx-auto mb-2 sm:mb-4 bg-yellow-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                                                <div class="w-5 h-5 sm:w-8 sm:h-8 bg-yellow-600 rounded flex items-center justify-center">
                                                    <span class="text-white font-bold text-xs">TB</span>
                                                </div>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">TeleBirr</h4>
                                            <p class="text-xs sm:text-sm text-gray-500">Mobile Money</p>
                                        </div>
                                    </label>
                                </div>

                                <!-- CBE Birr -->
                                <div class="payment-option" data-method="cbe_birr">
                                    <input type="radio" id="cbe_birr" name="payment_method" value="cbe_birr" class="sr-only" {{ old('payment_method') == 'cbe_birr' ? 'checked' : '' }}>
                                    <label for="cbe_birr" class="payment-card cursor-pointer block p-3 sm:p-6 border-2 border-gray-200 rounded-lg sm:rounded-xl hover:border-green-400 transition duration-200">
                                        <div class="text-center">
                                            <div class="w-10 h-10 sm:w-16 sm:h-16 mx-auto mb-2 sm:mb-4 bg-green-100 rounded-lg sm:rounded-xl flex items-center justify-center">
                                                <div class="w-5 h-5 sm:w-8 sm:h-8 bg-green-600 rounded flex items-center justify-center">
                                                    <span class="text-white font-bold text-xs">CBE</span>
                                                </div>
                                            </div>
                                            <h4 class="font-semibold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">CBE Birr</h4>
                                            <p class="text-xs sm:text-sm text-gray-500">Commercial Bank</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Payment Forms -->
                        <div class="space-y-4 sm:space-y-6">
                            <!-- Card Payment Form -->
                            <div id="card_payment_form" class="payment-form hidden">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg sm:rounded-xl p-4 sm:p-6">
                                    <h4 class="font-semibold text-blue-900 mb-3 sm:mb-4 flex items-center text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Card Payment Details
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cardholder Name</label>
                                            <input type="text" name="cardholder_name" value="{{ old('cardholder_name') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="John Doe" />
                                            @error('cardholder_name')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Card Number</label>
                                            <input type="text" name="card_number" value="{{ old('card_number') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="1234 5678 9012 3456" />
                                            @error('card_number')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                                                <input type="text" name="expiry" value="{{ old('expiry') }}"
                                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                    placeholder="MM/YY" />
                                                @error('expiry')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                                                <input type="text" name="cvv" value="{{ old('cvv') }}"
                                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                    placeholder="123" />
                                                @error('cvv')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chapa Form -->
                            <div id="chapa_form" class="payment-form hidden">
                                <div class="bg-orange-50 border border-orange-200 rounded-lg sm:rounded-xl p-4 sm:p-6">
                                    <h4 class="font-semibold text-orange-900 mb-3 sm:mb-4 flex items-center text-sm sm:text-base">
                                        <div class="w-4 h-4 sm:w-5 sm:h-5 bg-orange-600 rounded mr-2 flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">CH</span>
                                        </div>
                                        Chapa Payment Details
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                            <input type="text" name="chapa_phone" value="{{ old('chapa_phone') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="+251 9XX XXX XXX" />
                                            @error('chapa_phone')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction Reference</label>
                                            <input type="text" name="chapa_reference" value="{{ old('chapa_reference') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="Optional reference" />
                                            @error('chapa_reference')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TeleBirr Form -->
                            <div id="telebirr_form" class="payment-form hidden">
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg sm:rounded-xl p-4 sm:p-6">
                                    <h4 class="font-semibold text-yellow-900 mb-3 sm:mb-4 flex items-center text-sm sm:text-base">
                                        <div class="w-4 h-4 sm:w-5 sm:h-5 bg-yellow-600 rounded mr-2 flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">TB</span>
                                        </div>
                                        TeleBirr Payment Details
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mobile Number</label>
                                            <input type="text" name="telebirr_mobile" value="{{ old('telebirr_mobile') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="+251 9XX XXX XXX" />
                                            @error('telebirr_mobile')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction ID</label>
                                            <input type="text" name="telebirr_txn_id" value="{{ old('telebirr_txn_id') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="Transaction ID" />
                                            @error('telebirr_txn_id')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CBE Birr Form -->
                            <div id="cbe_birr_form" class="payment-form hidden">
                                <div class="bg-green-50 border border-green-200 rounded-lg sm:rounded-xl p-4 sm:p-6">
                                    <h4 class="font-semibold text-green-900 mb-3 sm:mb-4 flex items-center text-sm sm:text-base">
                                        <div class="w-4 h-4 sm:w-5 sm:h-5 bg-green-600 rounded mr-2 flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">CBE</span>
                                        </div>
                                        CBE Birr Payment Details
                                    </h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Account Number</label>
                                            <input type="text" name="cbe_account" value="{{ old('cbe_account') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="Account Number" />
                                            @error('cbe_account')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction Reference</label>
                                            <input type="text" name="cbe_reference" value="{{ old('cbe_reference') }}"
                                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 text-sm sm:text-base"
                                                placeholder="Reference Number" />
                                            @error('cbe_reference')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Submit Button - Fixed at bottom on mobile -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 sm:relative sm:bottom-auto sm:left-auto sm:right-auto sm:bg-transparent sm:border-t-0 sm:p-0 z-50">
                <button type="submit" form="paymentForm" id="submitPayment"
                    class="w-full inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg sm:rounded-xl hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Complete Payment
                </button>
            </div>

            <!-- Add bottom padding on mobile to account for fixed button -->
            <div class="h-20 sm:h-0"></div>

            <!-- Security Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg sm:rounded-xl p-3 sm:p-4 mb-4 sm:mb-0">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500 mr-2 sm:mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                    </svg>
                    <p class="text-blue-800 text-xs sm:text-sm">
                        <strong>Secure Payment:</strong> All transactions are encrypted and processed securely. Your payment information is protected with industry-standard security measures.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option');
            const paymentForms = document.querySelectorAll('.payment-form');
            const paymentCards = document.querySelectorAll('.payment-card');

            // Handle payment method selection
            paymentOptions.forEach(option => {
                const radio = option.querySelector('input[type="radio"]');
                const card = option.querySelector('.payment-card');

                option.addEventListener('click', function() {
                    const method = this.dataset.method;

                    // Reset all cards
                    paymentCards.forEach(c => {
                        c.classList.remove('border-blue-500', 'border-orange-500', 'border-yellow-500', 'border-green-500', 'bg-blue-50', 'bg-orange-50', 'bg-yellow-50', 'bg-green-50');
                        c.classList.add('border-gray-200');
                    });

                    // Hide all forms
                    paymentForms.forEach(form => {
                        form.classList.add('hidden');
                    });

                    // Activate selected card
                    const colors = {
                        'card_payment': ['border-blue-500', 'bg-blue-50'],
                        'chapa': ['border-orange-500', 'bg-orange-50'],
                        'telebirr': ['border-yellow-500', 'bg-yellow-50'],
                        'cbe_birr': ['border-green-500', 'bg-green-50']
                    };

                    if (colors[method]) {
                        card.classList.remove('border-gray-200');
                        card.classList.add(...colors[method]);
                    }

                    // Show corresponding form
                    const form = document.getElementById(method + '_form');
                    if (form) {
                        form.classList.remove('hidden');
                    }

                    // Check the radio button
                    radio.checked = true;
                });
            });

            // Auto-select if there's an old value
            const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
            if (checkedRadio) {
                const option = checkedRadio.closest('.payment-option');
                if (option) {
                    option.click();
                }
            }

            // Card number formatting
            const cardNumberInput = document.querySelector('input[name="card_number"]');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                    if (formattedValue !== e.target.value) {
                        e.target.value = formattedValue;
                    }
                });
            }

            // Expiry date formatting
            const expiryInput = document.querySelector('input[name="expiry"]');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }
        });
    </script>

    <style>
        .payment-card {
            transition: all 0.2s ease-in-out;
        }

        .payment-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .payment-option input:checked + .payment-card {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 640px) {
            body {
                padding-bottom: 80px;
            }
        }
    </style>
</x-app-layout>
