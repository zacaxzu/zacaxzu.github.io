<?php
//stvoreno radi lakšeg baratanja s ispisom
class Info
{
    protected $ime, $prezime, $br_mob, $mail_faks, $mail_priv, $nepolozeni, $god_studija, $smjer, $saznali, $napomena;

    function __construct($ime, $prezime, $br_mob, $mail_faks, $mail_priv, $nepolozeni, $god_studija, $smjer, $saznali, $napomena)
    {
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->br_mob = $br_mob;
        $this->mail_faks = $mail_faks;
        $this->mail_priv = $mail_priv;
        $this->nepolozeni = $nepolozeni;
        $this->god_studija = $god_studija;
        $this->smjer = $smjer;
        $this->saznali = $saznali;
        $this->napomena = $napomena;
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