// Start a demo game session in the casino201 sandbox (Node.js 18+).
// Requires CASINO201_ENDPOINT and CASINO201_API_KEY (see .env.example).
const { CASINO201_ENDPOINT, CASINO201_API_KEY } = process.env;
if (!CASINO201_ENDPOINT || !CASINO201_API_KEY) {
  console.error('Set CASINO201_ENDPOINT and CASINO201_API_KEY');
  process.exit(1);
}

const response = await fetch(`${CASINO201_ENDPOINT}/api/v1/game-sessions/start`, {
  method: 'POST',
  headers: {
    Authorization: `Bearer ${CASINO201_API_KEY}`,
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    game_id: 123, // use a demo game ID available to your sandbox
    player_id: 'player_456',
    currency: 'EUR',
    country_code: 'US',
    ip_address: '203.0.113.24',
    locale: 'en',
    device: 'mobile',
    return_url: 'https://yourcasino.com/lobby',
  }),
});

const body = await response.json();
if (!response.ok || !body.success) {
  console.error('Request failed', response.status, body);
  process.exit(1);
}
console.log('Load this URL for the player:', body.data.iframe_url);
