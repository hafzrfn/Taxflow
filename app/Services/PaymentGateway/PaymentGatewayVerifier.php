<?php
namespace App\Services\PaymentGateway;

class PaymentGatewayVerifier
{
    protected $secret;

    public function __construct()
    {
        $this->secret = env('PAYMENT_GATEWAY_SECRET', null);
    }

    public function verify(?string $signature, array $payload): bool
    {
        if (empty($this->secret) || empty($signature)) {
            // dev mode: allow if mock secret is empty
            return env('PAYMENT_GATEWAY_ALLOW_MOCK', true);
        }
        // example: signature = hash_hmac('sha256', json_encode($payload), secret)
        $calculated = hash_hmac('sha256', json_encode($payload), $this->secret);
        return hash_equals($calculated, $signature);
    }
}
