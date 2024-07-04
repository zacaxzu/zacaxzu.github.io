<?php
#tu ide dohvacanje baza i sveg ostalog

require_once __DIR__ .'/../app/database/db.class.php';

class ObavijestiService
{
    //Funkcija koja dohvaca samo 5 obavijesti od novijih prema starijima (DESC)!, funkcija koja dohvaca sve obavijesti...
    //... implementirana je kasnije!
    public function dohvatiObavijesti()
    {
        //spajamo se na bazu i izvršavamo odgovarajući upit
        try
        {
            $db = DB::getConnection();
            //dohvati 5 najnovijih obavijesti
            $st = $db->prepare('SELECT naslov, tijelo, datum_objave FROM obavijesti ORDER BY datum_objave DESC LIMIT 5');
            $st->execute();
        }
        catch(PDOException $e)
        {
            exit('PDO error ' . $e->getMessage());
        }

        $arrofobavijesti = array();
        while($row = $st->fetch(PDO::FETCH_ASSOC))
        {
            $arrofobavijesti[] = array(
                'naslov' => $row['naslov'],
                'tijelo' => $row['tijelo'],
                'datum_objave' => $row['datum_objave']
            );
        }
        return $arrofobavijesti;
    }

    public function pohraniObavijest($naslov, $tijelo){
        //spajamo se na bazu
        try
        {
            $db=DB::getConnection();
            $st=$db->prepare('INSERT INTO obavijesti (naslov,tijelo) 
                            VALUES (:naslov, :tijelo)');
            $st->execute(array('naslov'=>$naslov,'tijelo'=>$tijelo));
        }
        catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
        return;
    }
    
    //funkcija koja vraca ime i prezime admina
    public function dohvatiTrenutnogAdmina($online_admin)
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT ime, prezime FROM demosi WHERE username=:online_admin');
            $st->execute([':online_admin' => $online_admin]);

            $row = $st->fetch(PDO::FETCH_ASSOC);

            if ($row) 
            {
                return $row;
            } 
            else 
            {
                return null;
            }
        }
        catch(PDOException $e)
        { 
            exit('PDO error ' . $e->getMessage()); 
        }
    }

    //funkcijom vracamo polje e-mailova svih demosa
    public function dohvatiDemose(){
        //spajanje na bazu
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email FROM demosi WHERE ovlasti=1' );
			$st->execute();
		}
		catch(PDOException $e) 
        { 
            exit('PDO error ' . $e->getMessage()); 
        }

		$arrofmail = array();
		while($row = $st->fetch())
		{
			$arrofmail[] = $row['email'];
		}
		return $arrofmail;
    }

    //funkcija za slanje maila demonstratorima
    public function posaljiObavijestDemosima($naslov_obavijesti, $tijelo_obavijesti, $demosi, $ime_admin, $prezime_admin){
        $subject = $naslov_obavijesti;
        $message = 'Poštovani demostratore,' . "\n" . $tijelo_obavijesti;

        $message .= "\n" . "\n" . 'Lijep pozdrav,' . "\n" . $ime_admin . ' ' . $prezime_admin;
        $headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
                    'Reply-To: rp2@studenti.math.hr' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion() . "\r\n" .
                    'Content-Type: text/plain; charset=UTF-8' . "\r\n";

        // Posaljemo mail svim demonstratorima
        $isOK=1;
        foreach($demosi as $demos)
        {
            $isOK=mail($demos, $subject, $message, $headers);
        }
        if( !$isOK )
			exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );
        return 1;
    }

    //funkcija koja dohvaca sve obavijesti izvrsava se pritiskom odgovarajuceg gumba u php formi, pozove se u obavijestiController.class.php 
    public function dohvatiSveObavijesti(){
        //spajamo se na bazu i izvršavamo odgovarajući upit
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('SELECT naslov, tijelo, datum_objave FROM obavijesti ORDER BY datum_objave DESC');
            $st->execute();
        }
        catch(PDOException $e)
        {
            exit('PDO error ' . $e->getMessage());
        }

        $allnotif = array();
        while($row = $st->fetch(PDO::FETCH_ASSOC))
        {
            $allnotif[] = array(
                'naslov' => $row['naslov'],
                'tijelo' => $row['tijelo'],
                'datum_objave' => $row['datum_objave']
            );
        }
        return $allnotif;
    }

};


?>