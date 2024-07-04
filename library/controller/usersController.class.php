<?php

require_once __DIR__ . '/../model/libraryservice.class.php';
require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/adminpostavkeservice.class.php';

class UsersController
{
    public function index()
    {
        // Dohavtimo sve demose i njihove informacije

        $us=new UserService();
        $users=$us->getusers();

        require_once __DIR__ . '/../view/demosi/opci-podaci_html.php';
    }

};
