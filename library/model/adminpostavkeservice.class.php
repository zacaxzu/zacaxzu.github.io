<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/info.class.php';

class AdminPostavkeService
{
    public function dohvatiInfo()
    {
        try
        {
            $db=DB::getConnection();
            $st=$db->prepare('SELECT ime,prezime,br_mob,mail_faks,mail_priv,nepolozeni,god_studija,smjer,saznali,napomena FROM postani_info');
            $st->execute();
        }
        catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

        $arrofinfo = array();
		while( $row = $st->fetch() )
		{
			$arrofinfo[] = new Info( $row['ime'], $row['prezime'], $row['br_mob'], $row['mail_faks'], $row['mail_priv'], $row['nepolozeni'],
                                $row['god_studija'], $row['smjer'], $row['saznali'], $row['napomena']);
		}
		return $arrofinfo;
	}

  //mjesecni sati rada iz tablice demos
  public function getsati($username)
  {
      try
      {
          $db=DB::getConnection();
          $st=$db->prepare('SELECT mjesecni_sati FROM demosi WHERE username=:username');
          $st->execute(array('username'=>$username));
      }
      catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

      $row = $st->fetch();
      return $row;
}

public function pribrojisate($username,$sat)
{
    try
    {
        $db=DB::getConnection();
        $st=$db->prepare('UPDATE demosi SET mjesecni_sati=mjesecni_sati+:sat WHERE username=:username');
        $st->execute(array('username'=>$username, 'sat'=>$sat));
    }
    catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

    return;
}

public function resetsate()
{
    try
    {
        $db=DB::getConnection();
        $st=$db->prepare('UPDATE demosi SET mjesecni_sati=0');
        $st->execute();
    }
    catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

    return;
}

    public function dohvatiTermin($mail_faks)
    {
        try
        {
            $db=DB::getConnection();
            $st=$db->prepare('SELECT ime,prezime,mail_faks, dan, termin FROM postani_termini WHERE mail_faks=:mail_faks');
            $st->execute([':mail_faks' => $mail_faks]);
        }
        catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

        $arroftermin = array();
		while( $row = $st->fetch(PDO::FETCH_ASSOC))
		{
			$arroftermin[] = array('ime' => $row['ime'], 'prezime' => $row['prezime'], 'mail_faks' => $row['mail_faks'],
                            'dan' => $row['dan'], 'termin' => $row['termin']);
		}
		return $arroftermin;
	}

    public function dohvatiDemonstratore()
    {
        try
        {
            $db=DB::getConnection();
            $st = $db->prepare('SELECT ime, prezime, email, godina, smjer FROM demosi WHERE ovlasti = :ovlasti');
            $ovlasti_value = 1;
            $st->execute([':ovlasti' => $ovlasti_value]);
        }
        catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}

        $arrofdemosi = array();
		while( $row = $st->fetch(PDO::FETCH_ASSOC))
		{
			$arrofdemosi[] = array('ime' => $row['ime'], 'prezime' => $row['prezime'], 'email' => $row['email'],
                            'godina' => $row['godina'], 'smjer' => $row['smjer']);
		}
		return $arrofdemosi;
    }

    public function obrisiDemonstratora($email)
    {
        try
        {
            $db = DB::getConnection();
            $st = $db->prepare('DELETE FROM demosi WHERE email = :email');
            $st->execute([':email' => $email]);
        }
        catch(PDOException $e) {exit('PDO error ' . $e->getMessage());}
        return;
    }

};

?>
