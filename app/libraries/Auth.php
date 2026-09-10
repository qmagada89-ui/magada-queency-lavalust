<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Library: Auth
 * 
 * Automatically generated via CLI.
 */
class Auth {
    
    protected $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->library('session');
    }

    public function register($username, $password)
    {
        $existing = $this->_lava->db->table('users')
                        ->where('username', $username)
                        ->row();

        if ($existing) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        return $this->_lava->db->table('users')->insert([
            'username'   => $username,
            'password'   => $hash,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function attempt($username, $password)
    {
        $user = $this->_lava->db->table('users')
                        ->where('username', $username)
                        ->row();

        if ($user && password_verify($password, $user->password)) {
            $this->_lava->session->set_userdata([
                'user_id'   => $user->id,
                'username'  => $user->username,
                'logged_in' => true,
            ]);
            return true;
        }

        return false;
    }

    public function is_logged_in()
    {
        return (bool) $this->_lava->session->userdata('logged_in');
    }

    public function logout()
    {
        $this->_lava->session->unset_userdata(['user_id', 'username', 'logged_in']);
    }

}