<?php

require_once __DIR__ . '/../app/database/db.class.php';

class zaboravlozinkeService
{

    public function provjeraValjanosti($email)
    {

        // Prvo provjerimo nalazi li se mail u bazi
        $db = DB::getConnection();

        try
        {
            $st = $db->prepare( 'SELECT email FROM demosi WHERE email=:email' );
            $st->execute( array( 'email' => $email ) );
        }
        catch( PDOException $e ) 
        { 
            require_once __DIR__ . '/../view/login/zaborav-lozinke_html.php'; 
            echo 'Greska u bazi.';
            return 0; 
        }

        $row = $st->fetch();

        if( $row === false )
        {
            // Taj mail ne postoji, upit u bazu nije vratio ništa.
            require_once __DIR__ . '/../view/login/zaborav-lozinke_html.php';
            echo 'Ne postoji takav mail u bazi.';
            return 0;
        }

        // Buduci da postoji dohvatimo njegov username i registarcijski kod
        try
        {
            $st1 = $db->prepare( 'SELECT username, registracijski_kod FROM demosi WHERE email=:email' );
            $st1->execute( array( 'email' => $email ) );
        }
        catch( PDOException $e ) 
        { 
            require_once __DIR__ . '/../view/login/zaborav-lozinke_html.php'; 
            echo 'Greska u bazi.';
            return 0; 
        }

        $row = $st1->fetch();
       
        $this->posaljiMailZaReset($email, $row['username'], $row['registracijski_kod']);

        return 1;

    }

    private function posaljiMailZaReset($email, $username, $registrationSequence) {
        $subject = "Zaboravljena lozinka";
        $message = 'Poštovanje !' . "\n" . "\n" . 'Vaš username za stranicu demosa je " ' . $username . '". Ako želite promijeniti vašu lozinku, molim vas da stisnete na sljedeći link: ';
        $message .= 'http://' . $_SERVER['SERVER_NAME'] . htmlentities( dirname( $_SERVER['PHP_SELF'] ) ) . '/index.php?rt=login/potvrdiKod&sequence=' . $registrationSequence . "\n";
        $message .= "\n" . "\n" . 'U slučaju da ne želite, ignorirajte ovaj mail.';
		$headers  = 'From: rp2@studenti.math.hr' . "\r\n" .
		            'Reply-To: rp2@studenti.math.hr' . "\r\n" .
		            'X-Mailer: PHP/' . phpversion();
        $isOK=mail($email, $subject, $message, $headers);

        if( !$isOK )
			exit( 'Greška: ne mogu poslati mail. (Pokrenite na rp2 serveru.)' );
    }

    public function potvrdiPromjenu($registrationSequence) {

        $db = DB::getConnection();

        try {
            $st = $db->prepare('SELECT id FROM dz2_users WHERE registration_sequence = :registration_sequence');
            $st->execute(['registration_sequence' => $registrationSequence]);
            $user = $st->fetch();

            if (!is_null($user)) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function napraviPromjenuLozinke($password_hash, $registracijski_kod){

        // Mijenjamo lozinku tamo gdje se nalazi trazeni registracijski_kod
        $db = DB::getConnection();

        try
        {
            $st = $db->prepare('UPDATE demosi SET password_hash = :password_hash WHERE registracijski_kod = :registracijski_kod');
            $st->execute([
                'password_hash' => $password_hash,
                'registracijski_kod' => $registracijski_kod
            ]);

            // Provejrimo jel se ikoji red promijenio
            if ($st->rowCount() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        catch( PDOException $e ) 
        { 
            require_once __DIR__ . '/../view/login/zaborav-lozinke_html.php'; 
            echo 'Greska u bazi.';
            return 0; 
        }

    }

}
?>
