#!/usr/bin/env bash
# Start a demo game session in the casino201 sandbox.
# Requires CASINO201_ENDPOINT and CASINO201_API_KEY (see .env.example).
set -euo pipefail
[ -f .env ] && set -a && . ./.env && set +a

: "${CASINO201_ENDPOINT:?Set CASINO201_ENDPOINT}"
: "${CASINO201_API_KEY:?Set CASINO201_API_KEY}"

curl -sS -X POST "$CASINO201_ENDPOINT/api/v1/game-sessions/start" \
  -H "Authorization: Bearer $CASINO201_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "game_id": 123,
    "player_id": "player_456",
    "currency": "EUR",
    "country_code": "US",
    "ip_address": "203.0.113.24",
    "locale": "en",
    "device": "mobile",
    "return_url": "https://yourcasino.com/lobby"
  }'
echo
