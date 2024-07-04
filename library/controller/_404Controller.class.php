<?php


class _404Controller
{
    public function index()
    {
        $poruka = 'Pristupili ste nepostojećoj stranici.';

        require_once __DIR__ . '/../view/_404_index.php';
    }
}

?>
