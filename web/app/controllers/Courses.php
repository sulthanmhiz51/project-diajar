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
}
