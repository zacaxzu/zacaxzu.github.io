<?php

require_once __DIR__ . '/../model/loginservice.class.php';
require_once __DIR__ . '/../model/libraryservice.class.php';
require_once __DIR__ . '/../model/userservice.class.php';
require_once __DIR__ . '/../model/user.class.php';

class PostavkeController
{
    public function index()
    {
        $st=new UserService();

        $user=$st->getuser($_COOKIE['username']);
        require_once __DIR__ . '/../view/postavke/account_html.php';
    }

    public function updateaccount()
    {
        $st=new UserService();
        $user=$st->getuser($_COOKIE['username']);

        $noviuser=clone $user;

        //ako nije nista upisano u neko polje, nece se mijenjati
        //ako je upisano, provjeravamo da li je ispravno za to polje

        if(isset($_POST["username"]) && $_POST["username"]!==""){
          if(preg_match('/^[a-zA-Z]{1,20}$/', $_POST["username"])){
            $noviuser->__set('username',$_POST["username"]);
          }
          else{
            $poruka="Username se smije sastojati samo od slova!";
            require_once __DIR__ . '/../view/postavke/account_html.php';
            return;
          }
        }

        if(isset($_POST["ime"]) && $_POST["ime"]!==""){
          if(preg_match('/^[a-zA-ZčćšđžČĆŠĐŽ-]{2,20}$/',$_POST['ime'])){
            $noviuser->__set('ime',$_POST["ime"]);
          }
          else{
            $poruka="Ime (2-20 znakova) se smije sastojati samo od slova i crtice!";
            require_once __DIR__ . '/../view/postavke/account_html.php';
            return;
          }
        }


        if(isset($_POST["prezime"]) && $_POST["prezime"]!==""){
          if(preg_match('/^[a-zA-ZčćšđžČĆŠĐŽ-]{2,20}$/',$_POST['prezime'])){
            $noviuser->__set('prezime',$_POST["prezime"]);
          }
          else{
            $poruka="Prezime (2-20 znakova) se smije sastojati samo od slova i crtice!";
            require_once __DIR__ . '/../view/postavke/account_html.php';
            return;
          }
        }

        if(isset($_POST["email"]) && $_POST["email"]!==""){
          if(preg_match('/^[a-zA-Z0-9._-]+@[a-z]+\.[a-z]{2,}$/',$_POST['email'])){
            $noviuser->__set('email',$_POST["email"]);
          }
          else{
            $poruka="Email nije ispravno unesen!";
            return;
          }
        }

        if(isset($_POST["godina"]) && $_POST["godina"]!=='0'){
          $noviuser->__set('godina',$_POST["godina"]);
        }

        if(isset($_POST["smjer"]) && $_POST["smjer"]!==""){
          $noviuser->__set('smjer',$_POST["smjer"]);
        }
        else $noviuser->__set('smjer',$user->__get('smjer'));


        $uname=$st->setuser($noviuser);
        //ponovno postavljamo cookie za novi username
        setcookie('username',$uname,time()+(10*365*24*60*60));

        $user=$st->getuser($uname);
        $poruka="Promjene uspješno spremljene.";
        require_once __DIR__ . '/../view/postavke/account_html.php';
    }

    public function promjenasifre()
    {
        require_once __DIR__ . '/../view/postavke/promjenasifre_html.php';
    }

    public function updatesifra()
    {
        $username=$_COOKIE['username'];
        $oldpass=$_POST['oldpass'];
        $st=new LoginService();

        //je li stara šifra dobra
        $prov=$st->provjeraUBazi($username,$oldpass);
        if($prov===0){
          $poruka="Krivi unos stare šifre, pokušajte ponovno.";
          require_once __DIR__ . '/../view/postavke/promjenasifre_html.php';
          return;
        }

        $newpass=$_POST['newpass'];
        //je li nova šifra isto unesena oba puta
        if($_POST['newpass2']!==$newpass){
          $poruka="Unesite istu novu šifru oba puta!";
          require_once __DIR__ . '/../view/postavke/promjenasifre_html.php';
          return;
        }

        $us=new UserService();
        $newpass=password_hash( $newpass, PASSWORD_DEFAULT );
        $us->setpassword($username,$newpass);
        $poruka="Šifra uspješno promjenjena!";
        require_once __DIR__ . '/../view/postavke/promjenasifre_html.php';
    }

    public function darklight()
    {
        if(isset($_COOKIE['mode'])){
          if($_COOKIE['mode']==='0') {
            setcookie('mode',1,time()+(10*365*24*60*60));
            $darkmode=0;
          }
          else {
            setcookie('mode',0,time()+(10*365*24*60*60));
            $darkmode=1;
          }
        }
        else {
          setcookie('mode',0,time()+(10*365*24*60*60));
          $darkmode=1;
        }

        $st=new UserService();
        $user=$st->getuser($_COOKIE['username']);
        require_once __DIR__ . '/../view/postavke/account_html.php';
    }

    
};
