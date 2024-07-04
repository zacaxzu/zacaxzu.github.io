<?php

require_once __DIR__ . '/../model/postaniservice.class.php';
class PostaniDemosController
{
    public function index()
    {
        $poruka='';
        require_once __DIR__ . '/../view/login/postanidemos_html.php';
    }

};

?>