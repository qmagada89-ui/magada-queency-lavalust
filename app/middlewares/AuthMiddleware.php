<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * Middleware: AuthMiddleware
 * 
 * Automatically generated via CLI.
 */
class AuthMiddleware
{
  
    public function handle(Closure $next)
    {
        // TODO: Add your middleware logic here (authentication, authorization, etc.)

        $lava = lava_instance();

        // Matches the flag Auth::attempt() sets on a successful login,
        // so this stays in sync with whatever AuthController considers "logged in".
        if (!$lava->session->userdata('logged_in')) {
            redirect('login');
        }

        return $next();
    }
}
