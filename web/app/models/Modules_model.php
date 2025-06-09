<?php

class Modules_model
{
    private $table = 'modules';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}
