<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    
    private $student = [
        'student_id' => 'MCC2020-0709',
        'name'       => 'Queency A. Magada',
        'course'     => 'BS Information Technology',
        'year'       => '3rd Year',
        'section'    => 'F6',
        'email'      => 'you@example.com',
    ];

    private $portal_title = "Queency's Student Portal";


    public function index()
    {
        $_SESSION['student_access'] = true;

        $this->call->view('student/index', [
            'portal_title' => $this->portal_title,
            'student'      => $this->student,
            'denied'       => $this->request->get('denied') == 1,
        ]);
    }

    public function profile()
    {
        $this->call->view('student/profile', [
            'portal_title' => $this->portal_title,
            'student'      => $this->student,
        ]);
    }
}
