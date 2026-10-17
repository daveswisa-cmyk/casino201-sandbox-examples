# casino201 sandbox examples

Code examples for the **casino201 free casino game API sandbox**: launch a demo game session and verify signed wallet callbacks in cURL, Node.js and PHP.

casino201 is the developer hub for a casino game aggregation API with a free sandbox. Developers learn the API and test it for free; accounts, sandbox keys, top-ups and production keys are created on [casino-games-aggregation.com](https://casino-games-aggregation.com/register), which offers 4,000+ games from 129 studios behind one API and one prepaid balance.

- Sandbox overview: https://casino201.com/sandbox
- Full docs: https://casino201.com/docs
- Get a free sandbox key: https://casino-games-aggregation.com/register

> B2B only. casino201 is a developer and operator resource, not a gambling site. It accepts no wagers.

## What the sandbox gives you

- Free test API key on sign-up (no top-up, no crypto)
- Sandbox endpoint (sent with your sandbox key)
- Demo games
- Simulated wallet callbacks: `authenticate`, `balance`, `bet`, `win`, `rollback`, `reward`, signed with HMAC-SHA256
- Hosted test suite

## Quick start

1. Sign up at https://casino-games-aggregation.com/register and get your sandbox key.
2. Copy `.env.example` to `.env` and fill in the endpoint and key you received.
3. Run one of the examples:

```bash
# cURL
./examples/curl/start-session.sh

# Node.js 18+
node examples/node/start-session.mjs

# PHP 8+
php examples/php/start-session.php
```

Each example calls `POST /api/v1/game-sessions/start` and prints the `iframe_url` to load the demo game for a player.

## Start a game session

```
POST {CASINO201_ENDPOINT}/api/v1/game-sessions/start
Authorization: Bearer {CASINO201_API_KEY}
Content-Type: application/json
```

Request fields: `game_id`, `player_id`, `currency`, `country_code`, `ip_address`, `locale`, `device`, `return_url`.

Response:

```json
{
  "success": true,
  "data": {
    "session_id": 918274,
    "session_token": "8f2c41d9e7a3b5…",
    "expires_at": "2026-10-04T12:00:00+00:00",
    "iframe_url": "https://api.casino201.com/start_game?token=8f2c41d9e7a3b5…"
  }
}
```

(Example values. Use a demo game ID available to your sandbox.)

## Verify wallet callbacks

Every wallet callback carries an `X-Signature` header: HMAC-SHA256 of the **raw request body** with your webhook secret. Verify it before moving money.

- Node.js: [`examples/node/verify-callback.mjs`](examples/node/verify-callback.mjs)
- PHP: [`examples/php/verify-callback.php`](examples/php/verify-callback.php)

Keep the raw body bytes (don't re-serialize parsed JSON), compare in constant time, and use the signature encoding supplied with your key.

## Security

- Keep your API key and webhook secret server-side. Never ship them to a browser.
- Lock your key to your servers with an IP/CIDR allowlist.

## Postman

Import [`postman/casino201-sandbox.postman_collection.json`](postman/casino201-sandbox.postman_collection.json) and set the `endpoint` and `api_key` collection variables.

## Sandbox vs live

| | Sandbox | Live |
|---|---|---|
| Access | Free | Top-up from €500 in crypto |
| API key | Test key on sign-up | Production key |
| Games | Demo games | 4,000+ games / 129 studios (18,000+ on higher tier) |
| Balance | Simulated | One prepaid balance |
| Fee | Free testing | 6% of GGR, €0 setup, €0 monthly minimum |

Full field reference (callback payloads, error codes, rate limits) is included with your sandbox key.
