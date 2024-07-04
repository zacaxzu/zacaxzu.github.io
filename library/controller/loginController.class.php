<?php

require_once __DIR__ . '/../model/libraryservice.class.php';
require_once __DIR__ . '/../model/loginservice.class.php';
require_once __DIR__ . '/../model/zaboravlozinkeservice.class.php';
require_once __DIR__ . '/../model/rezervacijeprofservice.class.php';

require_once __DIR__ . '/../model/postaniservice.class.php';

class LoginController
{
    public function index()
    {
        require_once __DIR__ . '/../view/login/login_html.php';
    }

    public function postanidemos()
    {
        require_once __DIR__ . '/../view/login/postanidemos_html.php';
    }

    public function opisposla()
    {
        require_once __DIR__ . '/../view/login/opisposla_html.php';
    }

    public function rezervacijeProf()
    {
        require_once __DIR__ . '/../view/login/rezervacije-prof_html.php';
    }

    // Funkcije za promjenu zaboravljene lozinke
    public function zaborav()
    {
        require_once __DIR__ . '/../view/login/zaborav-lozinke_html.php';
    }

    public function slanjemaila()
    {
        $email = $_POST['email'];

        $zs = new zaboravlozinkeService;

        $result = $zs->provjeraValjanosti($email);

        if($result == 1){
            echo "Mail je uspješno poslan na traženu adresu";
        }
        else {
            echo "Dogodila se greška, mail nije poslan.";
        }
    }

    public function potvrdikod() {
        $registrationSequence = $_GET['sequence'];

        $zs = new zaboravlozinkeService;
        $result = $zs->potvrdiPromjenu($registrationSequence);

        if ($result) {
            require_once __DIR__ . '/../view/login/promjena-lozinke_html.php';
        } else {
            echo "Ovaj kod nije točan.";
        }
    }

    public function promijenilozinku() {
        if($_POST['psw1'] === $_POST['psw2']){

            $registrationSequence = $_GET['sequence'];

            $password_hash = password_hash($_POST['psw1'], PASSWORD_DEFAULT);

            $zs = new zaboravlozinkeService;

            $result = $zs->napraviPromjenuLozinke($password_hash, $registrationSequence);

            if($result == 1){
                require_once __DIR__ . '/../view/login/promjena-lozinke-uspjeh_html.php';
            } else {
                require_once __DIR__ . '/../view/login/promjena-lozinke-fail_html.php';
            }
        }
        else{
            require_once __DIR__ . '/../view/login/promjena-lozinke_html.php';
            echo "Ove dvije lozinke nisu iste!";
        }
    }

    // Funkcije za rezervaciju termina od strane profesora
    // Samo posaljem mail svim demosima adminima
    public function rezervacijaTermina()
    {
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email1 = $_POST['email1'];
        $email2 = $_POST['email2'];
        $datum = $_POST['datum'];
        $vrijeme = $_POST['vrijeme'];
        $prostorija = $_POST['prostorija'];
        $ljudi1 = $_POST['ljudi1'];
        $ljudi2 = $_POST['ljudi2'];

        $rs = new RezervacijeprofService;

        // Dohvatimo sve mailove admina iz baze te im posaljemo mail
        $admini = array();
        $admini = $rs->dohvatiAdmine();

        $result = $rs->posaljiMailZaRezervaciju($ime, $prezime, $email1, $email2, $datum, $vrijeme, $prostorija, $ljudi1, $ljudi2, $admini);

        if($result){
            $poruka = 'Vaš zahtjev je poslan. Admin demos će vam se uskoro javiti.';
            require_once __DIR__ . '/../view/login/rezervacije-prof_html.php';
        }
        else{
            $poruka = 'Greška, vaš zahtjev nije poslan';
            require_once __DIR__ . '/../view/login/rezervacije-prof_html.php';
        }
    }

    public function provjera()
    {

    //ako je korisnik vec zapamcen od prije
    if(isset($_COOKIE['username'])){
      $username = $_COOKIE['username'];
      $ls = new LoginService;

      $poruka=$ls->userprovjera($username);
      return;
    }

        // Provjeri sastoji li se ime samo od slova; ako ne, crtaj login formu.
		if( !isset( $_POST["uname"] ) || preg_match( '/[a-zA-Z]{1, 20}/', $_POST["uname"] ) ){
			require_once __DIR__ . '/../view/login/login_html.php';
			return;
		}

        // Možda se ne šalje password; u njemu smije biti bilo što.
		if( !isset( $_POST["psw"] ) )
            require_once __DIR__ . '/../view/login/login_html.php';

        // Sve je OK, provjeri jel ga ima u bazi.

        $username = $_POST["uname"];
        $password = $_POST["psw"];

        $ls = new LoginService;

        $poruka=$ls->provjeraUBazi($username, $password);

    }

    public function logout()
    {
        setcookie('username','',time()-50);
        setcookie('ovlasti','',time()-50);
        unset($_COOKIE['username']);
        unset($_COOKIE['ovlasti']);
        require_once __DIR__ . '/../view/login/login_html.php';
    }
    //funkcija koja obradjuje podatke poslane putem POST-a, provjere i poziva funkcije ako je sve dobro
    //za unos u samu bazu podataka kako bi admin imao uvid
    public function obradi()
    {
        $poruka='';
        $ps = new PostaniService();
        //PLAN: provjera polja za termine - treba minimalno 6, provjera reg. izraza za ime,prezime,broj mobitela,...

        if((!isset($_POST['ponedjeljak']) && empty($_POST['ponedjeljak'])) && (!isset($_POST['utorak']) && empty($_POST['utorak']))
        && (!isset($_POST['srijeda']) && empty($_POST['srijeda'])) && (!isset($_POST['cetvrtak']) && empty($_POST['cetvrtak']))
        && (!isset($_POST['petak']) && empty($_POST['petak']))){
            //svi checkboxovi su prazni
            $poruka = 'Označite termine!';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }

        //iduca provjera je imamo li minimalno oznaceno 6 termina, trebamo brojac
        $brojac_termina = 0;

        $selectedPon = [];
        $selectedUto = [];
        $selectedSri = [];
        $selectedCet = [];
        $selectedPet = [];

        //spremimo dobiveno u polja
        if (isset($_POST['ponedjeljak']))
            $selectedPon = $_POST['ponedjeljak'];
        if (isset($_POST['utorak']))
            $selectedUto = $_POST['utorak'];
        if (isset($_POST['srijeda']))
            $selectedSri = $_POST['srijeda'];
        if (isset($_POST['cetvrtak']))
            $selectedCet = $_POST['cetvrtak'];
        if (isset($_POST['petak']))
            $selectedPet = $_POST['petak'];

        //provjeravamo imamo li minimalno 6 termina
        foreach($selectedPon as $pon)
            $brojac_termina++;
        foreach($selectedUto as $uto)
            $brojac_termina++;
        foreach($selectedSri as $sri)
            $brojac_termina++;
        foreach($selectedCet as $cet)
            $brojac_termina++;
        foreach($selectedPet as $pet)
            $brojac_termina++;

        if($brojac_termina < 6)
        {
            $poruka = 'Trebate oznaciti minimalno 6 termina!';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }

        //provjeravamo ime,prezime,...

        if(empty($_POST['firstname'])|| !preg_match('/^[a-zA-ZčćšđžČĆŠĐŽ-]{2,20}$/',$_POST['firstname'])){
            $poruka='Za unos imena koristite slova i eventualno "-" !';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }

        if(empty($_POST['lastname'])|| !preg_match('/^[a-zA-ZčćšđžČĆŠĐŽ-]{2,20}$/',$_POST['lastname'])){
            $poruka='Za unos prezimena koristite slova i evenutalno "-" !';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }

        if(empty($_POST['brojmobitela'])|| !preg_match('/^\d{3} \d{4} \d{3}$/',$_POST['brojmobitela'])){
            $poruka='Unesite broj mobitela u prikazanoj (odgovarajućem) obliku npr. 097 1237 813.';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }

        if(empty($_POST['mailfaksa'])|| !preg_match('/^[a-z]+\.math@pmf\.hr$/',$_POST['mailfaksa'])){
            $poruka='Vaš mail (od fakulteta) ne zadovoljava oblik!';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }

        if(!empty($_POST['mailosobni']) && !preg_match('/^[a-zA-Z0-9._-]+@[a-z]+\.[a-z]{2,}$/',$_POST['mailosobni'])){
            $poruka='Vaš mail (osobni) ne zadovoljava oblik!';
            require_once __DIR__ . '/../view/login/postanidemos_html.php';
            return;
        }
        //kodom iznad provjerili smo ime, prezime, broj mobitela, mail od fakulteta, osobni mail

        $ime=$_POST['firstname'];
        $prezime=$_POST['lastname'];
        $brojmobitela=$_POST['brojmobitela'];
        $mailfaksa=$_POST['mailfaksa'];
        $mailosobni = '';
        if(isset($_POST['mailosobni']))
            $mailosobni=$_POST['mailosobni'];
        else
            $mailosobni= 'Osobni mail nije unesen';
        $nepolozeno=$_POST['polozeno'];
        $godina=$_POST['godina'];
        $smjer=$_POST['smjer'];
        $poziv='';
        $napomene='';

        if($_POST['poziv'] === 'Ostalo')
        {
            if(empty($_POST['poziv-ostalo']))
                $poziv = 'Student nije ništa napisao';
            else
                $poziv = $_POST['poziv-ostalo'];
        }
        else
        {
            $poziv = $_POST['poziv'];
        }

        if(empty($_POST['napomene']))
        {
            $napomene = 'Nema napomena';
        }
        else
            $napomene=$_POST['napomene'];

        //ako je kod došao do ovog dijela sve je OK, mozemo ubaciti u bazu :)
        $ps->ubaciPostaniInfo($ime,$prezime,$brojmobitela,$mailfaksa,$mailosobni,$nepolozeno,$godina,$smjer,$poziv,$napomene);

        $ponedjeljak='ponedjeljak'; $utorak='utorak'; $srijeda='srijeda'; $cetvrtak='četvrtak'; $petak='petak';

        //$ps->ubaciPostaniTermin($ime,$prezime,$mailfaksa,$...,$...);
        foreach($selectedPon as $pon)
            $ps->ubaciPostaniTermin($ime,$prezime,$mailfaksa,$ponedjeljak,$pon);
        foreach($selectedUto as $uto)
            $ps->ubaciPostaniTermin($ime,$prezime,$mailfaksa,$utorak,$uto);
        foreach($selectedSri as $sri)
            $ps->ubaciPostaniTermin($ime,$prezime,$mailfaksa,$srijeda,$sri);
        foreach($selectedCet as $cet)
            $ps->ubaciPostaniTermin($ime,$prezime,$mailfaksa,$cetvrtak,$cet);
        foreach($selectedPet as $pet)
            $ps->ubaciPostaniTermin($ime,$prezime,$mailfaksa,$petak,$pet);

        $poruka = 'Uspješno ste ispunili formular!';
        header('Location: index.php?rt=adminpostavke/uspjesnoIspunjenaForma'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
        exit;
    }

    //ova funkcija je kreirana tako da ako korisnik refresha stranicu i dalje ce mu pisati odgovarajuca poruka,
    //ali se forma nece ponovno prenijeti na bazu sto bi uzrokovalo duplanje,...
    public function uspjesnoIspunjenaForma()
    {
        $poruka = 'Uspješno ste ispunili formular!';
        require_once __DIR__ . '/../view/login/postanidemos_html.php';
        return;
    }


};
