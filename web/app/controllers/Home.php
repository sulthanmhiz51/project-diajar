<?php

class Home extends Controller
{
    public function index()
    {
        $data = [
            'judul' => 'Diajar - Platform Belajar Online',
            'welcome' => 'Bersama Diajar, lebih dekat menuju versi terbaikmu',
            'catch_phrase' => 'Upgrade ilmu, Unlock potensi',
            'BASEURL' => BASEURL
        ];

        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
