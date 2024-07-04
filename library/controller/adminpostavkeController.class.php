<?php

require_once __DIR__ . '/../model/loginservice.class.php';
require_once __DIR__ . '/../model/libraryservice.class.php';
require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '/../model/user.class.php';
require_once __DIR__ . '/../model/adminpostavkeservice.class.php';
require_once __DIR__ . '/../model/info.class.php';

class AdminpostavkeController
{
    public function index()
    {
        $st=new UserService();

        $user=$st->getuser($_COOKIE['username']);

        require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
    }

    public function popissati(){
        $st=new UserService();
        $users=$st->getusers();
        $tjedni=array();

        $as=new AdminPostavkeService();

        $mjes=array();
        foreach($users as $us){
          $username=$us->__get('username');
          $mjes[]=$as->getsati($username);
        }

        $var=array();
        $dir=__DIR__ . '/../../server/aktuarski.json';
        if (file_exists($dir)) {
            $var=file_get_contents($dir);
            $var=json_decode($var);
        }

        foreach($var as $tab){
          foreach($tab as $str){
            if($str!=""){
              if(isset($tjedni[$str])){
                $tjedni[$str]++;
              }
              else{
                $tjedni[$str]=1;
              }
            }
          }
        }

        require_once __DIR__ . '/../view/admin-postavke/popissati.php';
    }

    public function pribrojisate(){
      $as=new AdminPostavkeService();
      $st=new UserService();
      $users=$st->getusers();
      $tjedni=array();
      $var=array();

      $dir=__DIR__ . '/../../server/aktuarski.json';
      if (file_exists($dir)) {
          $var=file_get_contents($dir);
          $var=json_decode($var);
      }

      foreach($var as $tab){
        foreach($tab as $str){
          if($str!=""){
            if(isset($tjedni[$str])){
              $tjedni[$str]++;
            }
            else{
              $tjedni[$str]=1;
            }
          }
        }
      }

      $mjes=array();
      foreach($users as $us){
        $username=$us->__get('username');
        $mjes[]=$as->getsati($username);
      }

      //zbrajamo tjedne sate u mjesečne za svakog usera
      foreach($tjedni as $key=>$val){
        $as->pribrojisate($key,$val);
      }

      $mjes=array();
      foreach($users as $us){
        $username=$us->__get('username');
        $mjes[]=$as->getsati($username);
      }

      $poruka="Sati uspješno pribrojeni!<br>";
      require_once __DIR__ . '/../view/admin-postavke/popissati.php';
    }

    public function resetsate(){
      $as=new AdminPostavkeService();
      $st=new UserService();
      $users=$st->getusers();
      $tjedni=array();

      $var=array();
      $dir=__DIR__ . '/../../server/aktuarski.json';
      if (file_exists($dir)) {
          $var=file_get_contents($dir);
          $var=json_decode($var);
      }

      foreach($var as $tab){
        foreach($tab as $str){
          if($str!=""){
            if(isset($tjedni[$str])){
              $tjedni[$str]++;
            }
            else{
              $tjedni[$str]=1;
            }
          }
        }
      }

      $as->resetsate();

      $mjes=array();
      foreach($users as $us){
        $username=$us->__get('username');
        $mjes[]=$as->getsati($username);
      }
      
      $poruka="Sati uspješno resetirani!<br>";
      require_once __DIR__ . '/../view/admin-postavke/popissati.php';
    }

    public function updatereg()
    {
      $noviuser=new User(0,0,0,0,0,0,0,0);

      if(isset($_POST["username"])){
        $us = new UserService();
        $username = $_POST["username"];
        if($us -> getuser($username) === 0){
          if(preg_match('/^[a-zA-Z]{1,20}$/', $_POST["username"])){
            $noviuser->__set('username',$_POST["username"]);
          }
          else{
            $poruka="Username se smije sastojati samo od slova!";
            require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
            return;
          }
        } 
        
        else {
          $poruka="Vec postoji korisnim sa takvim korisnickim usernameom!";
          require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
          return;
        }
      }

      if(isset($_POST["ime"])){
        if(preg_match('/^[a-zA-ZčćšđžČĆŠĐŽ-]{2,20}$/',$_POST['ime'])){
          $noviuser->__set('ime',$_POST["ime"]);
        }
        else{
          $poruka="Ime (2-20 znakova) se smije sastojati samo od slova i crtice!";
          require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
          return;
        }
      }


      if(isset($_POST["prezime"])){
        if(preg_match('/^[a-zA-ZčćšđžČĆŠĐŽ-]{2,20}$/',$_POST['prezime'])){
          $noviuser->__set('prezime',$_POST["prezime"]);
        }
        else{
          $poruka="Prezime (2-20 znakova) se smije sastojati samo od slova i crtice!";
          require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
          return;
        }
      }

      if($_POST['password']!==$_POST['password2']){
        $poruka="Unesite istu novu šifru oba puta!";
        require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
        return;
      }
      $password=password_hash($_POST['password'], PASSWORD_DEFAULT );

      if(isset($_POST["email"])){
        if(preg_match('/^[a-zA-Z0-9._-]+@[a-z]+\.[a-z]{2,}$/',$_POST['email'])){
          $noviuser->__set('email',$_POST["email"]);
        }
        else{
          $poruka="Email nije ispravno unesen!";
          return;
        }
      }
      else $noviuser->__set('email',"");

      if(isset($_POST["godina"])){
        $noviuser->__set('godina',$_POST["godina"]);
      }

      if(isset($_POST["smjer"]))
        $noviuser->__set('smjer',$_POST["smjer"]);
      else $noviuser->__set('smjer',"");

      if(isset($_POST["ovlasti"])){
        $noviuser->__set('ovlasti',$_POST["ovlasti"]);
      }

      $kod=bin2hex(random_bytes(10));

      $st=new UserService();
      $st->makeuser($noviuser,$password, $kod);

      $poruka="Promjene uspješno spremljene.";
      require_once __DIR__ . '/../view/admin-postavke/registracija_html.php';
    }

    //prikazuje podatke o studentima koji su ispunili formu postani demos
    public function noviDemos()
    {
        $broj_novih = 0;
        $st=new UserService();
        $user=$st->getuser($_COOKIE['username']);

        $ap = new AdminPostavkeService();
        $infoList = $ap->dohvatiInfo();
        $terminList = [];
        foreach($infoList as $info){
            $terminList[$broj_novih] = $ap->dohvatiTermin($info->mail_faks);
            $broj_novih++;
        }
        require_once __DIR__ . '/../view/admin-postavke/novidemos_html.php';
    }

    public function micanjeDemosa()
    {
        $st=new UserService();
        $user=$st->getuser($_COOKIE['username']);

        $ap = new AdminPostavkeService();
        $demosList = $ap->dohvatiDemonstratore();

        require_once __DIR__ . '/../view/admin-postavke/micanjedemosa_html.php';
    }

    public function obrisiDemosa()
    {
        $st=new UserService();
        $user=$st->getuser($_COOKIE['username']);

        if(!isset($_POST['obrisi']))
        {
            header('Location: index.php?rt=adminpostavke/micanjeDemosa');
            exit;
        }
        else
        {
            $ap = new AdminPostavkeService();
            $email = $_POST['obrisi'];
            $ap->obrisiDemonstratora($email);
            $demosList = $ap->dohvatiDemonstratore();
            require_once __DIR__ . '/../view/admin-postavke/micanjedemosa_html.php';
        }
    }

    public function uploadSlika()
    {
        $st=new UserService();
        $user=$st->getuser($_COOKIE['username']);

        require_once __DIR__ . '/../view/admin-postavke/upravljanjegalerijom_html.php';
    }


    public function obradiUpload()
    {
        //provjera postoji li nešto u submit
        if(isset($_POST['submit']))
        {
            if($_FILES['image']['error'] === 0)
            {
                $image = $_FILES['image'];
                $nazivSlike = $_POST['nazivslike'];

                $imageFileType=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                //navodimo koji su tipovi dozvoljeni
                $allowedTypes = array('jpg', 'jpeg', 'png');

                if(in_array($imageFileType, $allowedTypes))
                {
                    //generiramo ime za sliku
                    $imageName = $nazivSlike . '.' . $imageFileType;

                    //moramo provjeriti naziv slike
                    $files = glob("view/images/slike_galerija/*.{jpg,jpeg,png}", GLOB_BRACE);
                    foreach ($files as $file) {
                        if( $imageName === basename($file)){
                            $upload = 'Slika s tim nazivom već postoji, molimo Vas odaberite neki drugi naziv!';
                            require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
                            return;
                        }
                    }
                    //spremamo sliku o odgovarajući direktorij (u ovom slučaju view/images/slike_galerija)
                    move_uploaded_file($image['tmp_name'],dirname(__FILE__) . '/../view/images/slike_galerija/' . $imageName);
                    $upload = 'Uspješno ste prenjeli sliku!';
                    header('Location: index.php?rt=adminpostavke/uspjesanPrijenos'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
                    exit;
                }
                else
                {
                    $upload = 'Dozovljeni su formati .jpg, .jpeg i .png, provjerite Vaš format slike.';
                    require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
                    return;
                }
            }
            else
            {
                 // Ispis grešaka koje se mogu dogoditi!
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $upload = 'Veličina slike premašuje dozvoljenu veličinu.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $upload = 'Slika je djelomično prenesena.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $upload = 'Nijedna slika nije prenesena.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $upload = 'Prijenos slike zaustavljen zbog ekstenzije.';
                    break;
                default:
                    $upload = 'Došlo je do greške prilikom uploada slike.';
                    break;
            }
            require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
            return;
            }
        }
    }

    //ova funkcija je kreirana tako da ako korisnik refresha stranicu i dalje ce mu pisati odgovarajuca poruka,
    //ali se slika nece ponovno prenijeti na stanicu sto bi uzrokovalo duplanje,...
    public function uspjesanPrijenos()
    {
        $upload = 'Uspješno ste prenijeli sliku!';
        require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
        return;
    }

    //funkcija koja će provjeriti ima li slika unesenog naziva iz forme u galerija_html.php
    //ako da, uklonit ce je, ako ne ispisat ce odgovarajucu poruku
    public function obradiDelete()
    {
        if(isset($_POST['submit']))
        {
            $nazivSlike = $_POST['naziv_slike'];
            //putanja do slike
            $imagePath = dirname(__FILE__) . '/../view/images/slike_galerija/' . $nazivSlike;

            if(file_exists($imagePath))
            {
                if(unlink($imagePath)) //ovo omogucava brisanje unlink()
                {
                    $brisanje = 'Slika je uspješno uklonjena!';
                    require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
                    return;
                }
                else
                {
                    $brisanje = 'Došlo je do greške prilikom brisanja slike!';
                    require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
                    return;
                }
            }
            else
            {
                $brisanje = 'Slika tog naslova ne postoji, probajte ponovno (u naslov mora biti uključeno sve)';
                require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
                return;
            }
        }
        require_once 'view/admin-postavke/upravljanjegalerijom_html.php';
        return;
    }

};
