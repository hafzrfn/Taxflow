<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * VerifyCsrfToken
 *
 * This middleware protects your application against CSRF attacks.
 * Routes listed in the $except array will be excluded from CSRF verification.
 *
 * NOTE:
 * - If your payment gateway sends callbacks to /api/payments/callback, you should
 *   add that exact URI here (without domain) so Laravel will not require a CSRF token.
 * - Prefer verifying the gateway callback using a signature/HMAC (see PaymentGatewayVerifier)
 *   rather than disabling CSRF in favor of security.
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be added to the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * Put callback/webhook endpoints here. Use exact paths relative to your app root.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Payment gateway webhook callback (API route)
        'api/payments/callback',

        // If you prefer webhook on web routes, add the path as well:
        // 'payments/callback',

        // Add other webhook endpoints you need to exclude from CSRF, for example:
        // 'api/dukcapil/*',
        // 'webhook/*',
    ];
}
