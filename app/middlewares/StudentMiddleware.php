<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle(Closure $next)
    {
        if (empty($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
            redirect('student?denied=1');
        }

        return $next();
    }
}
