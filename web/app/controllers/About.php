<?php

class About extends Controller
{
    public function index($nama = 'Sulthan', $umur = 20)
    {
        $data['nama'] = $nama;
        $data['umur'] = $umur;
        $data['judul'] = 'About';

        $this->view('templates/header', $data);
        $this->view('about/index', $data);
        $this->view('templates/footer');
    }

    public function page()
    {
        $this->view('about/page');
    }
}