<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';

class UserService
{

  public function getusers()
  {
      $db = DB::getConnection();

      try
  {
    $st = $db->prepare( 'SELECT id,username,ime,prezime,email,godina,smjer,ovlasti FROM demosi' );
    $st->execute( array( ) );
  }
  catch( PDOException $e ) { require_once __DIR__ . '/../view/postavke/account_html.php'; echo 'Greska u bazi.';return; }

    $arr=array();
    while(1){
      $row = $st->fetch();
      if ($row === false) {
        return $arr;
      }
      $new = new User($row['id'],$row['username'],$row['ime'],
              $row['prezime'],$row['email'],$row['godina'],
              $row['smjer'],$row['ovlasti']);
      $arr[]=$new;
    }
    return $arr;
  }

    public function getuser($username)
    {
        $db = DB::getConnection();

        try
		{
			$st = $db->prepare( 'SELECT id,username,ime,prezime,email,godina,smjer,ovlasti FROM demosi where username=:username' );
			$st->execute( array( 'username' => $username ) );
		}
		catch( PDOException $e ) { require_once __DIR__ . '/../view/postavke/account_html.php'; echo 'Greska u bazi.';return; }

      $row = $st->fetch();

      if ($row === false) {
        return 0; // Vraca nula ako nije pronaden ni jedan user sa tim imenom
      }

        $new = new User($row['id'],$row['username'],$row['ime'],
                $row['prezime'],$row['email'],$row['godina'],
                $row['smjer'],$row['ovlasti']);

        return $new;
    }

    public function setuser($noviuser)
    {
        $db = DB::getConnection();

        try
		{
      $stariuser=$_COOKIE['username'];
			$st = $db->prepare( 'UPDATE demosi set prezime=:prezime, ime=:ime, smjer=:smjer where username=:cookie' );
			$st->execute( array('prezime' => $noviuser->__get('prezime'), 'ime' => $noviuser->__get('ime'),
        'smjer' => $noviuser->__get('smjer'), 'cookie' => $stariuser));
      $st2 = $db->prepare( 'UPDATE demosi set username=:username, email=:email, godina=:godina where username=:cookie');
      $st2->execute(array('username' => $noviuser->__get('username'), 'email' => $noviuser->__get('email'), 'godina' => $noviuser->__get('godina'), 'cookie' => $stariuser));
		}
		catch( PDOException $e ) {
      echo 'Greska u bazi.';
      require_once __DIR__ . '/../view/postavke/account_html.php'; return;
    }

      return $noviuser->__get('username');
    }

    public function makeuser($noviuser,$password,$kod)
    {
        $db = DB::getConnection();

        try
		{
      $username=$noviuser->__get('username');
      $ime=$noviuser->__get('ime');
      $prezime=$noviuser->__get('prezime');
      $email=$noviuser->__get('email');
      $godina=$noviuser->__get('godina');
      $smjer=$noviuser->__get('smjer');
      $ovlasti=$noviuser->__get('ovlasti');

			$st = $db->prepare( 'INSERT INTO demosi(username, password_hash, ime, prezime, email, godina, smjer, ovlasti, registracijski_kod)
        VALUES (:username, :password, :ime, :prezime, :email, :godina, :smjer, :ovlasti, :kod)' );
			$st->execute( array('username' => $username, 'password' => $password, 'ime' => $ime, 'prezime' => $prezime,
        'email' => $email, 'godina' => $godina, 'smjer' => $smjer, 'ovlasti' => $ovlasti, 'kod' => $kod));
		}
		catch( PDOException $e ) {
      $poruka='Greška u bazi, pokušajte ponovno';
      require_once __DIR__ . '/../view/postavke/registracija_html.php';
      return;
    }

      return;
    }

    public function setpassword($username,$password)
    {
        $db = DB::getConnection();

        try
		{
      $st = $db->prepare( 'UPDATE demosi set password_hash=:password where username=:username' );
			$st->execute( array('password' => $password, 'username' => $username));
    }
		catch( PDOException $e ) {
      echo 'Greska u bazi.';
      require_once __DIR__ . '/../view/postavke/promjenasifre_html.php'; return;
    }

    return 1;
    }
}
