<?php

require_once __DIR__ . '/../model/obavijestiservice.class.php';
class ObavijestiController
{
    public function index()
    {
        if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0')
        {
            //ovisno o tome je li admin po ovlastima (0)

            $st=new ObavijestiService();
            $notifications=$st->dohvatiObavijesti();

            require_once __DIR__ . '/../view/obavijesti/obavijesti-admin_html.php';
        }
        else
        {
            //ili demonstrator (1)

            $st=new ObavijestiService();
            $notifications=$st->dohvatiObavijesti();

            require_once __DIR__ . '/../view/obavijesti/obavijesti-demos_html.php';
        }
    }

    public function obradiObavijest(){
        $st=new ObavijestiService();
        $notifications=$st->dohvatiObavijesti();
        if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '1')
        {
            //demonstrator (1)
            require_once __DIR__ . '/../view/obavijesti/obavijesti-demos_html.php';
        }
        else
        {
            //admin po ovlastima (0)
            //dalje sad provjeravamo unos nove obavijesti
            if(isset($_POST['btn']))
            {
                //moramo obraditi primljene podatke i ubaciti u tablicu!
                //u $_POST['naslov_poruke'] i $_POST['tijelo_poruke'] nalazi se ono što trebamo za ubačaj u tablicu

                $naslov_obavijesti = $_POST['naslov_poruke'];
                $tijelo_obavijesti = $_POST['tijelo_poruke'];
                
                $online_admin = $_COOKIE['username'];

                $os = new ObavijestiService();
                $os->pohraniObavijest($naslov_obavijesti, $tijelo_obavijesti);

                //treba poslati obavijest svim demosima (znaci svima koji imaju ovlast === 1)
                //prvo dohvatimo demose i onda im saljemo!
                //u demose ce biti dohvacen njihov e-mail
                $demosi = array();
                $demosi = $os->dohvatiDemose();

                //dohvacamo ime i prezime admina kako bi napisali na kraju maila tko je to posalo :)
                $trenutni_admin = $os->dohvatiTrenutnogAdmina($online_admin);

                if ($trenutni_admin !== null) 
                {
                    $ime_admin = $trenutni_admin['ime'];
                    $prezime_admin = $trenutni_admin['prezime'];
                } 
                else 
                {
                    echo "Administrator nije pronađen.";
                }

                $rez_poslano = $os->posaljiObavijestDemosima($naslov_obavijesti, $tijelo_obavijesti, $demosi, $ime_admin, $prezime_admin);

                //provjera s porukom
                if($rez_poslano)
                {
                    header("Location: index.php?rt=obavijesti/index"); //da se zaustavi ponovni unos u tablicu kod osvjezavanja stranice
                }
                else
                {
                    header("Location: index.php?rt=obavijesti/index"); //da se zaustavi ponovni unos u tablicu kod osvjezavanja stranice
                    exit();
                }

                header("Location: index.php?rt=obavijesti/index"); //da se zaustavi ponovni unos u tablicu kod osvjezavanja stranice
                exit(); 
            }
            else
            {
                require_once __DIR__ . '/../view/obavijesti/obavijesti-admin_html.php';
            }
        }
    }

    public function sveObavijesti(){
        $st=new ObavijestiService();
        $allNotifications=$st->dohvatiSveObavijesti();
        require_once __DIR__ . '/../view/obavijesti/sveobavijesti_html.php';
    }

};

?>