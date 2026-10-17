<?php
// Start a demo game session in the casino201 sandbox (PHP 8+).
// Requires CASINO201_ENDPOINT and CASINO201_API_KEY (see .env.example).
$endpoint = getenv('CASINO201_ENDPOINT');
$apiKey   = getenv('CASINO201_API_KEY');
if (!$endpoint || !$apiKey) {
    fwrite(STDERR, "Set CASINO201_ENDPOINT and CASINO201_API_KEY\n");
    exit(1);
}

$payload = json_encode([
    'game_id'      => 123, // use a demo game ID available to your sandbox
    'player_id'    => 'player_456',
    'currency'     => 'EUR',
    'country_code' => 'US',
    'ip_address'   => '203.0.113.24',
    'locale'       => 'en',
    'device'       => 'mobile',
    'return_url'   => 'https://yourcasino.com/lobby',
]);

$curl = curl_init($endpoint . '/api/v1/game-sessions/start');
curl_setopt_array($curl, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ],
]);

$body = json_decode(curl_exec($curl), true);
if (!($body['success'] ?? false)) {
    fwrite(STDERR, "Request failed\n");
    var_dump($body);
    exit(1);
}
echo 'Load this URL for the player: ' . $body['data']['iframe_url'] . PHP_EOL;
