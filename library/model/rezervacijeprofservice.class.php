<?php

require_once __DIR__ . '/../app/database/db.class.php';

class RezervacijeprofService
{

    public function dohvatiAdmine()
    {
        try
		{
			$db = DB::getConnection();
			$st = $db->prepare( 'SELECT email FROM demosi WHERE ovlasti=0' );
			$st->execute();
		}
		catch( PDOException $e ) { exit( 'PDO error ' . $e->getMessage() ); }

		$arr = array();
		while( $row = $st->fetch() )
		{
			$arr[] = $row['email'];
		}

		return $arr;
    }

    public function posaljiMailZaRezervaciju($ime, $prezime, $email1, $email2, $datum, $vrijeme, $prostorija, $ljudi1, $ljudi2, $admini) {
        $subject = "Rezeravcija snimanja";
        $message = 'Poštovanje !' . "\n" . "\n" . $ime . " " . $prezime . ' je zatražio rezervaciju snimanja dana ' . $datum . ' u vremenu ' . $vrijeme . '.';
        if(isset($prostorija)){
            $message .= ' Snimanje je poželjno imati u prostoriji ' . $prostorija . '. ';
        }
        $message .= "\n" . 'Za više detalja, možete im se javiti na mail:' . "\n";
        $message .= 'email(službeni): ' . $email1 . "\n";
        if(isset($prostorija)){
            $message .= 'email(neslužbeni): ' . $email1 . "\n";
        }
        $message .= "\n" . "\n" . 'Lijep pozdrav,' . "\n" . 'Demosi';
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();

        // Posaljemo mail svim adminima
        $isOK=1;
        foreach($admini as $admin){
            $isOK=mail($admin, $subject, $message, $headers);
        }

        if( !$isOK )
			exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );

        return 1;
    }

}
?>
