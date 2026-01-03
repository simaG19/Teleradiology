<?php

namespace App\Http\Controllers;

use App\Services\ChapaService;
use Illuminate\Http\Request;

class ChapaPayController extends Controller
{
    protected $chapaService;

    public function __construct(ChapaService $chapaService)
    {
        $this->chapaService = $chapaService;
    }

    public function initializePayment(Request $request)
    {
        $paymentData = [
            'amount' => $request->amount,
            'currency' => 'ETB',
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'tx_ref' => uniqid(), // unique reference
            'callback_url' => route('payment.callback'),
            'return_url' => route('payment.success'),
            'customization' => [
                'title' => 'Your Company Name',
                'description' => 'Payment for services'
            ]
        ];

        $response = $this->chapaService->initializeTransaction($paymentData);

        if ($response && $response['status'] === 'success') {
            return redirect()->away($response['data']['checkout_url']);
        }

        return back()->with('error', 'Payment initialization failed.');
    }

    public function paymentCallback(Request $request)
    {
        $transactionId = $request->tx_ref;
        
        if ($request->status === 'successful') {
            $verification = $this->chapaService->verifyTransaction($transactionId);
            
            if ($verification && $verification['status'] === 'success') {
                // Payment successful, update your database
                return redirect()->route('payment.success')
                    ->with('success', 'Payment completed successfully!');
            }
        }

        return redirect()->route('payment.failed')
            ->with('error', 'Payment failed or was cancelled.');
    }

    public function paymentSuccess()
    {
        return view('uploads.success');
    }

    public function paymentFailed()
    {
        return view('payment.failed');
    }
}