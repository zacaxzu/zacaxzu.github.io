<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class GalerijaController
{
    public function index()
    {
        require_once 'view/galerija/galerija_html.php';
    }
};