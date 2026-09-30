<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * AuthController
 * Public endpoints for register / login / refresh / logout,
 * plus a protected "me" endpoint. Uses the LavaLust Api library
 * (JWT access token + hashed refresh token stored in refresh_tokens).
 */
class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->library('api');
    }

    // POST api/auth/register  { username, email, password }
    public function register()
    {
        $this->api->require_method('POST');
        $in = $this->api->body();

        $username = trim($in['username'] ?? '');
        $email    = trim($in['email'] ?? '');
        $password = $in['password'] ?? '';

        $errors = [];
        if ($username === '' || strlen($username) > 50) $errors['username'] = 'Username is required (max 50 characters).';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))  $errors['email']    = 'Enter a valid email address.';
        if (strlen($password) < 6)                        $errors['password'] = 'Password must be at least 6 characters.';
        if ($errors) {
            $this->api->respond(['error' => 'Validation failed', 'errors' => $errors], 422);
        }

        $exists = $this->db->raw(
            'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$username, $email]
        )->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $this->api->respond_error('Username or email is already taken.', 409);
        }

        $this->db->raw(
            'INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())',
            [$username, $email, password_hash($password, PASSWORD_BCRYPT), 'user']
        );

        $this->api->respond(['message' => 'Account created. You can now log in.'], 201);
    }

    // POST api/auth/login  { username, password }  (username OR email)
    public function login()
    {
        $this->api->require_method('POST');
        $in = $this->api->body();

        $login    = trim($in['username'] ?? '');
        $password = $in['password'] ?? '';

        $user = $this->db->raw(
            'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1',
            [$login, $login]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->api->respond_error('Wrong username or password.', 401);
        }

        $tokens = $this->api->issue_tokens([
            'id'   => $user['id'],
            'role' => $user['role'],
        ]);

        $tokens['user'] = [
            'id'       => (int) $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'role'     => $user['role'],
        ];

        $this->api->respond($tokens);
    }

    // POST api/auth/refresh  { refresh_token }
    public function refresh()
    {
        $this->api->require_method('POST');
        $in = $this->api->body();
        // Revokes the old refresh token and responds with a new pair
        $this->api->refresh_access_token($in['refresh_token'] ?? '');
    }

    // POST api/auth/logout  { refresh_token }
    public function logout()
    {
        $this->api->require_method('POST');
        $in = $this->api->body();
        $this->api->revoke_refresh_token($in['refresh_token'] ?? '');
        $this->api->respond(['message' => 'Logged out']);
    }

    // GET api/auth/me   (Authorization: Bearer <access_token>)
    public function me()
    {
        $this->api->require_method('GET');
        $auth = $this->api->require_jwt();

        $user = $this->db->raw(
            'SELECT id, username, email, role, created_at FROM users WHERE id = ?',
            [$auth['sub']]
        )->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $this->api->respond_error('User not found', 404);
        }
        $this->api->respond($user);
    }
}
