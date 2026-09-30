<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/*
| API Library config — values come from environment variables so that
| no secret is committed to GitHub. Set them in Render > Environment,
| and in your local .env file (which is gitignored).
*/

$config['api_helper_enabled']       = TRUE;

// Token lifetimes (seconds)
$config['payload_token_expiration'] = 900;      // 15 minutes
$config['refresh_token_expiration'] = 604800;   // 7 days
 
// Signing keys — each MUST be at least 32 characters
$config['jwt_secret']        = getenv('JWT_SECRET')        ?: '';
$config['refresh_token_key'] = getenv('REFRESH_TOKEN_KEY') ?: '';

// JWT claims
$config['jwt_issuer']   = getenv('JWT_ISSUER')   ?: '';
$config['jwt_audience'] = getenv('JWT_AUDIENCE') ?: '';

// CORS — comma-separated list in FRONTEND_ORIGIN, e.g.
// FRONTEND_ORIGIN=https://your-frontend.onrender.com,http://localhost:5173
$origins = array_filter(array_map('trim', explode(',', getenv('FRONTEND_ORIGIN') ?: 'http://localhost:5173')));
$config['allow_origin'] = count($origins) === 1 ? reset($origins) : array_values($origins);

// Refresh token table (created by migration)
$config['refresh_token_table'] = 'refresh_tokens';

// Rate limiting (uses the cache library)
$config['rate_limit_enabled']  = TRUE;
$config['rate_limit_requests'] = 60;
$config['rate_limit_seconds']  = 60;
