<?php
// Verify a casino201 wallet callback signature (PHP).
// X-Signature = HMAC-SHA256 of the raw request body, keyed with your webhook secret.

function verifyCallback(string $rawBody, string $signature,
    string $webhookSecret, callable $decodeSignature): bool {
    if ($signature === '' || $webhookSecret === '') return false;
    try {
        // Decode X-Signature using the encoding supplied with your key.
        $received = $decodeSignature($signature);
        if (!is_string($received)) return false;
        $expected = hash_hmac('sha256', $rawBody, $webhookSecret, true);
        return hash_equals($expected, $received);
    } catch (Throwable $error) {
        return false;
    }
}

// Usage in your wallet endpoint:
// $rawBody   = file_get_contents('php://input');
// $signature = $_SERVER['HTTP_X_SIGNATURE'] ?? '';
// if (!verifyCallback($rawBody, $signature, getenv('CASINO201_WEBHOOK_SECRET'), $decodeSignature)) {
//     http_response_code(401); exit;
// }
// $payload = json_decode($rawBody, true);
// // handle authenticate | balance | bet | win | rollback | reward
// Full payload field reference is included with your sandbox key.
