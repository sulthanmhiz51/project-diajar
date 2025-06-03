<?php

class Courses extends Controller
{
    public function index()
    {
        $data['judul'] = 'Courses';
        $this->view('templates/header', $data);
        $this->view('courses/index');
        $this->view('templates/footer');
    }

    public function detail()
    {
    $data['judul'] = 'Detail Kursus';

    $this->view('templates/header', $data);
    $this->view('courses/detail', $data);
    $this->view('templates/footer');
    }

}
