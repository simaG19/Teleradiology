<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChapaController extends Controller
{
    private $base = 'https://api.chapa.co/v1';
    private function secretKey() {
        return config('services.chapa.secret');
    }

    // === STEP 1: Initialize Chapa Payment ===
    public function initializeForBatch(Request $request, Batch $batch)
    {
        try {
            $amount = (float) ($batch->fileType->price_per_file ?? 0);
            if ($amount <= 0) {
                return response()->json(['error' => 'Invalid amount'], 422);
            }

            $email = $request->input('email', auth()->user()->email ?? 'noemail@example.com');
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['error' => 'Valid email required'], 422);
            }

            $txRef = 'batch' . $batch->id . '_' . strtoupper(substr(uniqid(), -8));
            $txRef = substr($txRef, 0, 50);

            $title = 'Batch-' . $batch->id;
            $description = 'Payment for batch ' . $batch->id;

            $payload = [
                'amount' => $amount,
                'currency' => 'ETB',
                'email' => $email,
                'first_name' => auth()->user()->name ? explode(' ', auth()->user()->name)[0] : 'Customer',
                'last_name' => auth()->user()->name ? (explode(' ', auth()->user()->name)[1] ?? '') : '',
                'tx_ref' => $txRef,
                'callback_url' => route('chapa.callback', $batch->id),
                'return_url' => route('chapa.success', $batch->id),
                'customization' => [
                    'title' => substr(preg_replace('/[^A-Za-z0-9\-\_\. ]/', '', $title), 0, 16),
                    'description' => substr(preg_replace('/[^A-Za-z0-9\-\_\. ]/', '', $description), 0, 50),
                ],
            ];

            Log::info('Chapa init payload:', $payload);

            $response = Http::withToken($this->secretKey())->post("{$this->base}/transaction/initialize", $payload);
            Log::info('Chapa init response: ' . $response->body());

            if (!$response->ok()) {
                return response()->json(['error' => 'Failed to initialize Chapa payment', 'body' => $response->json()], 500);
            }

            $data = $response->json();
            $checkoutUrl = data_get($data, 'data.checkout_url');
            if (!$checkoutUrl) {
                return response()->json(['error' => 'No checkout URL returned'], 500);
            }

            // Save tx_ref for later verification
            $batch->update(['tx_ref' => $txRef]);

            return response()->json(['checkout_url' => $checkoutUrl]);
        } catch (\Throwable $e) {
            Log::error('Chapa initialize error: ' . $e->getMessage());
            return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
        }
    }

    // === STEP 2: Callback (Chapa verifies transaction) ===
public function callback(Request $request, $id)
{
    $batch = Batch::findOrFail($id);

    // Get transaction reference from various possible sources
    $txRef = $batch->tx_ref
        ?? $request->input('tx_ref')
        ?? $request->input('trx_ref')
        ?? $request->query('tx_ref')
        ?? $request->query('trx_ref')
        ?? $request->input('reference')
        ?? null;

    Log::info('Chapa callback received', [
        'batch_id' => $batch->id,
        'tx_ref' => $txRef,
        'request_data' => $request->all()
    ]);

    if (!$txRef) {
        Log::error('No transaction reference found', ['request' => $request->all()]);
        return response()->json(['error' => 'Missing transaction reference'], 400);
    }

    try {
        // Verify transaction with Chapa
        $verifyUrl = $this->base . "/transaction/verify/{$txRef}";
        $response = Http::withToken($this->secretKey())
            ->timeout(30)
            ->get($verifyUrl);

        $data = $response->json();

        if ($response->failed()) {
            Log::error('Chapa verification failed', [
                'status' => $response->status(),
                'response' => $data
            ]);
            return response()->json(['error' => 'Verification failed'], 500);
        }

        // Check transaction status
        $status = strtolower($data['data']['status'] ?? $data['status'] ?? '');

        $successStatuses = ['success', 'successful', 'paid', 'complete', 'completed'];

        if (in_array($status, $successStatuses)) {
            // Update batch status
            $batch->update([
                'paid' => true,
                'tx_ref' => $txRef,
                'payment_gateway' => 'chapa',
                'payment_verified_at' => now(),
            ]);

            Log::info('Batch payment status updated', [
                'batch_id' => $batch->id,
                'status' => $status,
                'tx_ref' => $txRef
            ]);

            // Return success response (Chapa expects 200 OK)
            return response()->json(['status' => 'success', 'message' => 'Payment verified']);
        } else {
            Log::warning('Chapa transaction not successful', [
                'status' => $status,
                'data' => $data
            ]);
            return response()->json(['status' => 'failed', 'message' => 'Payment not successful'], 400);
        }

    } catch (\Exception $e) {
        Log::error('Chapa callback error: ' . $e->getMessage(), [
            'batch_id' => $batch->id,
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Server error'], 500);
    }
}



    // === STEP 3: Success Page ===
    // public function success(Batch $batch)
    // {
    //     return view('uploads.success', compact('batch'));
    // }

    public function success(Request $request, $id)
{
    $batch = Batch::findOrFail($id);

    // If already paid, just show success
    if ($batch->paid) {
        return view('uploads.success', compact('batch'));
    }

    // Get transaction reference
    $txRef = $batch->tx_ref
        ?? $request->input('tx_ref')
        ?? $request->input('trx_ref')
        ?? $request->query('tx_ref')
        ?? $request->query('trx_ref')
        ?? null;

    if ($txRef) {
        try {
            // Verify payment
            $verifyUrl = $this->base . "/transaction/verify/{$txRef}";
            $response = Http::withToken($this->secretKey())->get($verifyUrl);

            if ($response->ok()) {
                $data = $response->json();
                $status = strtolower($data['data']['status'] ?? $data['status'] ?? '');

                $successStatuses = ['success', 'successful', 'paid'];

                if (in_array($status, $successStatuses)) {
                    $batch->update([
                        'paid' => true,
                        'tx_ref' => $txRef,
                        'payment_gateway' => 'chapa',
                        'payment_verified_at' => now(),
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Chapa success verification failed: ' . $e->getMessage());
        }
    }

    return view('uploads.success', compact('batch'));
}

    // === STEP 4: Cancel Page ===
    public function cancel()
    {
        return view('uploads.cancel');
    }
}
