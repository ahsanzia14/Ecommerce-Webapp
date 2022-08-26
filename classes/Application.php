<?php

class Application
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
    }

}