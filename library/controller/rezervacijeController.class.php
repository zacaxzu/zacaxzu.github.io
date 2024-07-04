<?php

class RezervacijeController
{
    public function aktuarski()
    {
        require_once __DIR__ . '/../view/rezervacije/aktuarski_html.php';
    }

    public function doktorski()
    {
        require_once __DIR__ . '/../view/rezervacije/doktorski.php';
    }

    public function praktikumi()
    {
        require_once __DIR__ . '/../view/rezervacije/praktikumi.php';
    }

    public function snimanja()
    {
        require_once __DIR__ . '/../view/rezervacije/snimanja.php';
    }
}

?>
