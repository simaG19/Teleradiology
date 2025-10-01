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



<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitPayment');
    submitBtn.addEventListener('click', async function(e) {
        e.preventDefault();

        submitBtn.disabled = true;
        submitBtn.innerText = 'Redirecting...';

        const res = await fetch("{{ route('checkout.create', $batch->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        });

        if (!res.ok) {
               const err = await res.json().catch(()=>({error: 'unknown'}));
    alert('Failed to create checkout session: ' + (err.error || JSON.stringify(err)));
            submitBtn.disabled = false;
            submitBtn.innerText = 'Complete Payment';
            return;
        }

        const data = await res.json();
        const stripe = Stripe("{{ config('services.stripe.key') }}");

        const { error } = await stripe.redirectToCheckout({ sessionId: data.id });
        if (error) {
            console.error(error);
            alert(error.message);
            submitBtn.disabled = false;
            submitBtn.innerText = 'Complete Payment';
        }
    });
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
