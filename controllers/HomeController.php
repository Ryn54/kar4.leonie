<?php

class HomeController
{
    public function index($data = [])
    {
        extract($data);
        require_once 'views/home/index.php';
    }
}
