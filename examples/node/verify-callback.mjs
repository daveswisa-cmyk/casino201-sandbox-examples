// Verify a casino201 wallet callback signature (Node.js).
// X-Signature = HMAC-SHA256 of the raw request body, keyed with your webhook secret.
import { createHmac, timingSafeEqual } from 'node:crypto';

/**
 * @param {Buffer} rawBody          exact bytes received (do not re-serialize parsed JSON)
 * @param {string} signature        value of the X-Signature header
 * @param {string} webhookSecret    your webhook secret (server-side only)
 * @param {(sig: string) => Buffer} decodeSignature  decode using the encoding supplied with your key
 */
export function verifyCallback(rawBody, signature, webhookSecret, decodeSignature) {
  if (!signature || !webhookSecret) return false;
  try {
    const received = decodeSignature(signature);
    if (!Buffer.isBuffer(received)) return false;
    const expected = createHmac('sha256', webhookSecret).update(rawBody).digest();
    return received.length === expected.length && timingSafeEqual(received, expected);
  } catch {
    return false;
  }
}

// Usage (e.g. Express with express.raw({ type: 'application/json' })):
// app.post('/wallet/:action', (req, res) => {
//   const ok = verifyCallback(req.body, req.get('X-Signature'), process.env.CASINO201_WEBHOOK_SECRET, decodeSignature);
//   if (!ok) return res.status(401).end();
//   const payload = JSON.parse(req.body.toString('utf8'));
//   // handle authenticate | balance | bet | win | rollback | reward
// });
// Full payload field reference is included with your sandbox key.
