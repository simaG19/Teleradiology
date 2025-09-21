<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function show(Batch $batch)
    {
        // return your existing pay blade (you already have it)
        return view('uploads.pay', compact('batch'));
    }

    public function createCheckoutSession(Request $request, Batch $batch)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // amount in minor units (ETB is two-decimal currency => multiply by 100)
        $amount = (int) round($batch->fileType->price_per_file * 100);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'etb',
                    'product_data' => [
                        'name' => "Batch #{$batch->id} - " . ($batch->fileType->name ?? 'File'),
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'batch_id' => $batch->id,
            ],
            'success_url' => route('payments.success', $batch->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function success(Request $request, Batch $batch)
    {
        // Optionally verify session ID and payment status server-side:
        $sessionId = $request->get('session_id');
        if ($sessionId) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if ($session && $session->payment_status === 'paid') {
                // Mark batch as paid (adapt columns to your schema)
                $batch->update([
                    'paid' => true,
                    // 'payment_reference' => $session->payment_intent,
                ]);
            }
        }

        return view('uploads.success', compact('batch')); // create a simple success blade
    }

    public function cancel()
    {
        return view('uploads.cancel'); // simple cancel blade
    }

    // webhook
    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpoint_secret);
        } catch(\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $batchId = $session->metadata->batch_id ?? null;
            if ($batchId) {
                $batch = Batch::find($batchId);
                if ($batch) {
                    $batch->update([
                        'paid' => true,
                        // 'payment_reference' => $session->payment_intent ?? null,
                    ]);
                }
            }
        }

        return response('ok', 200);
    }
}
