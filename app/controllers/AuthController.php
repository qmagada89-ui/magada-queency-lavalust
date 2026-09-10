<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: AuthController
 * 
 * Automatically generated via CLI.
 */
class AuthController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function register()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $password = $this->io->post('password');

            if ($username === '' || $password === '') {
                $this->call->view('auth/register', ['error' => 'Username and password are required.']);
                return;
            }

            if ($this->auth->register($username, $password)) {
                redirect('login');
            }

            $this->call->view('auth/register', ['error' => 'That username is already taken.']);
            return;
        }

        $this->call->view('auth/register');
    }

    

        public function login()
    {
        $this->call->library('auth');

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->attempt($username, $password)) {
                redirect('products');
            }

            $this->call->view('auth/login', ['error' => 'Invalid username or password.']);
            return;
        }

        $this->call->view('auth/login');
    }

    public function logout()
    {
        $this->call->library('auth');
        $this->auth->logout();
        redirect('login');
    }









}