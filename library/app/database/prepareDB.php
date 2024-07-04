<?php

// Manualno inicijaliziramo bazu ako veÄ‡ nije.
require_once 'db.class.php';

$db = DB::getConnection();

$has_tables = false;

try
{
    $st = $db->prepare(
        'SHOW TABLES LIKE :tblname'
    );

    $st->execute( array( 'tblname' => 'demosi' ) );
    if( $st->rowCount() > 0 )
        $has_tables = true;

}
catch( PDOException $e ) { exit( "PDO error [show tables]: " . $e->getMessage() ); }


if( $has_tables )
{
    exit( 'Tablica demosi već postojć. Obrište ih pa probajte ponovno.' );
}


try
{
    $st = $db->prepare(
        'CREATE TABLE IF NOT EXISTS demosi (' .
        'id int NOT NULL PRIMARY KEY AUTO_INCREMENT,' .
        'username varchar(50) NOT NULL,' .
        'password_hash varchar(255) NOT NULL,'.
        'ime varchar(50) NOT NULL,' .
        'prezime varchar(50) NOT NULL,' .
        'email varchar(50) NOT NULL,' .
        'godina int NOT NULL,' .
        'smjer varchar(50) NOT NULL,' .
        'ovlasti int,' .
        'registracijski_kod varchar(20) NOT NULL' .
        ')'
    );

    $st->execute();
}
catch( PDOException $e ) { exit( "PDO error [create dz2_users]: " . $e->getMessage() ); }

echo "Napravio tablicu demosi.<br />";


// Ubaci neke korisnike unutra
try
{
    $st = $db->prepare( 'INSERT INTO demosi(username, password_hash, ime, prezime, email, godina, smjer, ovlasti, registracijski_kod) VALUES (:username, :password, :ime, :prezime, :email, :godina, :smjer, :ovlasti, :registracijski_kod)' );

    $st->execute( array( 'username' => 'demos', 'password' => password_hash( 'demos123', PASSWORD_DEFAULT ), 'ime' => 'Demos', 'prezime' => 'Demosić', 'email' => 'demos.math@pmf.hr', 'godina' => 1, 'smjer' => 'Računarstvo i matematika', 'ovlasti' => 0, 'registracijski_kod' => 'sjkadhaskdh' ) );
    $st->execute( array( 'username' => 'ana', 'password' => password_hash( 'aninasifra', PASSWORD_DEFAULT ), 'ime' => 'Ana', 'prezime' => 'Anić', 'email' => 'anaanic.math@pmf.hr', 'godina' => 2, 'smjer' => 'Matematička statistika', 'ovlasti' => 1, 'registracijski_kod' => 'asjkdhiasd' ) );
    $st->execute( array( 'username' => 'mirko', 'password' => password_hash( 'mirkovasifra', PASSWORD_DEFAULT ), 'ime' => 'Mirko', 'prezime' => 'Mirkić', 'email' => 'mirkmirk.math@pmf.hr', 'godina' => 1, 'smjer' => 'Financijska matematika', 'ovlasti' => 1, 'registracijski_kod' => 'hasdgjkasd' ) );
    $st->execute( array( 'username' => 'pero', 'password' => password_hash( 'perinasifra', PASSWORD_DEFAULT ), 'ime' => 'Pero', 'prezime' => 'Perić', 'email' => 'peroperi.math@pmf.hr', 'godina' => 2, 'smjer' => 'Teorijska matematika', 'ovlasti' => 1, 'registracijski_kod' => 'sda6sda78s' ) );
    $st->execute( array( 'username' => 'nikola', 'password' => password_hash( '12345', PASSWORD_DEFAULT ), 'ime' => 'Nikola', 'prezime' => 'Kašnar', 'email' => 'nikokasn.math@pmf.hr', 'godina' => 1, 'smjer' => 'Računarstvo i matematika', 'ovlasti' => 0, 'registracijski_kod' => 'sdgfsfsdff' ) );
}
catch( PDOException $e ) { exit( "PDO error [insert dz2_users]: " . $e->getMessage() ); }

echo "Ubacio u tablicu demosi.<br />";


?>
