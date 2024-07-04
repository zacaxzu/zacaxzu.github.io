<?php

require_once __DIR__ . '/../app/database/db.class.php';

class loginService
{

  public function userprovjera($username)
  {

      $db = DB::getConnection();

      try
  {
    $st = $db->prepare( 'SELECT password_hash FROM demosi WHERE username=:username' );
    $st->execute( array( 'username' => $username ) );
  }
  catch( PDOException $e ) { require_once __DIR__ . '/../view/login/login_html.php'; echo 'Greska u bazi.';return; }

      $row = $st->fetch();

      if( $row === false )
  {
    // Taj user ne postoji, upit u bazu nije vratio ništa.
    require_once __DIR__ . '/../view/login/login_html.php';
    $poruka= 'Ne postoji korisnik s tim imenom.';
    return $poruka;
  }
      else
  {
    require_once __DIR__ . '../../controller/usersController.class.php';
    $od=new UsersController();
        $od->index();
        return 1;
  }

  }

    public function provjeraUBazi($username, $password)
    {

        $db = DB::getConnection();

        try
		{
			$st = $db->prepare( 'SELECT password_hash, ovlasti FROM demosi WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { $poruka= 'Greska u bazi.'; require_once __DIR__ . '/../view/login/login_html.php'; return; }

        $row = $st->fetch();

        if( $row === false )
		{
			// Taj user ne postoji, upit u bazu nije vratio ništa.

			$poruka= 'Ne postoji korisnik s tim imenom.';
			require_once __DIR__ . '/../view/login/login_html.php';
		}
        else
		{


			// Postoji user. Dohvati hash njegovog passworda.
			$hash = $row[ 'password_hash'];


			// Da li je password dobar?
			if( password_verify( $password, $hash ))
			{
        //ako je korisnik ulogiran od prije
        //znaci da je ovo provjera pri mijenjanju sifre
        if(isset($_COOKIE['username'])){
          return 1;
        }

				// Dobar password. Ulogiraj ga i posalji na pocetni ekran.
        // Moramo dohvatiti i njegove ovlasti
        setcookie('username',$username,time()+(10*365*24*60*60));

        $ovlasti = $row['ovlasti'];
        setcookie('ovlasti',$ovlasti,time()+(10*365*24*60*60));

        // Ova linija je potrebna da se cookie zapamti pri prvom ulasku na stranicu
        header("Location: index.php");

				require_once __DIR__ . '../../controller/usersController.class.php';
				$od=new UsersController();
	        	$od->index();
				return 1;
			}
			else
			{
        //ako je korisnik ulogiran od prije
        //znaci da je ovo provjera pri mijenjanju sifre
        if(isset($_COOKIE['username'])){
          return 0;
        }

				// Nije dobar password. Crtaj opet login formu s pripadnom porukom.
				$poruka= 'Postoji user, ali password nije dobar.';
				require_once __DIR__ . '/../view/login/login_html.php';
			}
		}

    }

}
?>
