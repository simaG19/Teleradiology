<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ChapaService
{
    protected $client;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.chapa.secret_key');
        $this->baseUrl = config('services.chapa.base_url', 'https://api.chapa.co/v1/');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function initializeTransaction(array $data)
    {
        try {
            $response = $this->client->post('transaction/initialize', [
                'json' => $data
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Chapa API Error: ' . $e->getMessage());
            return null;
        }
    }

    public function verifyTransaction($transactionId)
    {
        try {
            $response = $this->client->get("transaction/verify/{$transactionId}");
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            Log::error('Chapa Verification Error: ' . $e->getMessage());
            return null;
        }
    }
}