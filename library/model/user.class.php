<?php
class User
{
    protected $id, $username, $ime, $prezime, $email, $godina, $smjer, $ovlasti;

    function __construct($id, $username, $ime, $prezime, $email, $godina, $smjer, $ovlasti)
    {
        $this->id = $id;
        $this->username = $username;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->godina = $godina;
        $this->email = $email;
        $this->smjer = $smjer;
        $this->ovlasti = $ovlasti;
    }

    function __get($property)
    {
        if (property_exists($this, $property))
            return $this->$property;
    }

    function __set($property, $value)
    {
        if (property_exists($this, $property))
            return $this->$property = $value;
    }
}
