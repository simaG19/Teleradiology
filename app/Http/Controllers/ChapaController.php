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

    // Try to find tx/ref from batch or request (handle various key names)
    $txRef = $batch->tx_ref
        ?? $request->get('tx_ref')
        ?? $request->get('trx_ref')
        ?? $request->query('trx_ref')
        ?? $request->query('tx_ref')
        ?? $request->get('trxref')
        ?? $request->get('reference')
        ?? null;

    Log::info("Chapa callback invoked for batch {$batch->id}", [
        'tx_ref_from_batch' => $batch->tx_ref,
        'tx_ref_from_request' => $request->get('tx_ref'),
        'trx_ref_from_request' => $request->get('trx_ref'),
        'all_query' => $request->query(),
        'all_input' => $request->all(),
    ]);

    if (!$txRef) {
        Log::warning("Chapa callback missing tx_ref for batch {$batch->id}");
        return response()->json(['error' => 'Missing transaction reference'], 400);
    }

    try {
        $verifyUrl = "{$this->base}/transaction/verify/{$txRef}";
        $res = Http::withToken($this->secretKey())->get($verifyUrl);

        Log::info('Chapa verify status: ' . $res->status());
        Log::info('Chapa verify response: ' . $res->body());

        if (!$res->ok()) {
            Log::warning('Chapa verification HTTP error', ['status' => $res->status(), 'body' => $res->body()]);
            return response()->json(['error' => 'Verification failed', 'body' => $res->json()], 500);
        }

        $data = $res->json();
        $status = data_get($data, 'data.status') ?? data_get($data, 'status');

        $normalized = is_string($status) ? strtolower($status) : $status;
        Log::info('Chapa verify parsed status', ['status' => $status, 'normalized' => $normalized]);

        if ($normalized === 'success' || $normalized === 'successful' || $normalized === 'paid') {
            // Persist tx_ref if missing and mark paid
            $batch->tx_ref = $txRef;
            $batch->paid = true;
            $saved = $batch->save();

            Log::info('Batch update', ['batch_id' => $batch->id, 'saved' => $saved, 'paid' => $batch->paid]);

            return redirect()->route('chapa.success', $batch->id);
        }

        Log::info('Chapa transaction not successful', ['status' => $status]);
        return redirect()->route('chapa.cancel');
    } catch (\Throwable $e) {
        Log::error('Chapa verify error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return redirect()->route('chapa.cancel');
    }
}



    // === STEP 3: Success Page ===
    public function success(Batch $batch)
    {
        return view('uploads.success', compact('batch'));
    }

    // === STEP 4: Cancel Page ===
    public function cancel()
    {
        return view('uploads.cancel');
    }
}
