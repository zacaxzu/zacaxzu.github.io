<?php 
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-admin-postavke.php'; ?>

<?php require_once __DIR__ . '/../_header.php'; ?>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">



<h2>Novoprijavljeni demonstratori <?php
    if ($broj_novih === 0) {
        $broj_novih = '';
    }
    if ($broj_novih !== '') {
        echo '(' . $broj_novih . ')';
    }
?> </h2>

<?php
    $brojac = 0;
    //prvo cemo ispisati za novoprijavljenog demosa sve podatke iz tablice postani_info,
    // a zatim kreirati tablicu gdje ce za istog demosa biti termini kada moze biti na "poslu"
    // to radimo tako da cemo za odg. demosa dohvatiti sve termine pomocu njegovog mail_faks
    foreach($infoList as $info)
    {
        echo 'Ime: '. $info->ime . '<br><hr>'.
            'Prezime: '. $info->prezime . '<br><hr>'.
            'Broj mobitela: '. $info->br_mob . '<br><hr>'.
            'E-mail (studentski): '. $info->mail_faks . '<br><hr>'.
            'E-mail (privatni): '. $info->mail_priv . '<br><hr>'.
            'Preostalo nepoloženih kolegija na prvoj godini? '. $info->nepolozeni . '<br><hr>'.
            'Godina studija: '. $info->god_studija . '<br><hr>'.
            'Smjer: '. $info->smjer . '<br><hr>'.
            'Za ovaj posao sam saznao: '. $info->saznali . '<br><hr>'.
            'Napomena: '. $info->napomena . '<br><hr>';
        echo '<h3> Dostupnost (budućeg) demonstratora ' . $info->ime . ' '. $info->prezime . ' po danima u tjednu: </h3>';
        
        echo '<table class="table-style-one"> <tr> <th>Dan</th> <th>Termin</th> </tr>';
        foreach($terminList[$brojac] as $termin){
        echo '<tr>' . '<td>' . $termin['dan'] .'</td>' . '<td>' . $termin['termin'] . '</td>';
        }
        echo '</table> <hr class="linijaa">';
        $brojac++;
    }

?>

</div>
    
</body>

</html>