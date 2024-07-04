<?php
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-admin-postavke.php'; ?>

<?php require_once __DIR__ . '/../_header.php';

//css za ovo je u novidemos_html.css
?>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">

    <h2>Popis demosa sa njihovim satima rada</h2>

    <?php if (isset($poruka)) echo $poruka . '<br>'; ?>

    <table id="popissati">
    <th>ID</th><th>Username</th><th>Ime</th>
    <th>Prezime</th><th>E-mail</th><th>Godina</th><th>Smjer</th>
    <th>Ovlasti</th><th>Mjesečni sati</th>
    <?php
    $i=0;
    foreach($users as $a) {
      echo '<tr><td>'. $a->__get('id') . '</td><td>'. $a->__get('username') . '</td><td>'. $a->__get('ime')  .
            '</td><td>'. $a->__get('prezime') . '</td><td>'. $a->__get('email') . '</td>' .
            '<td>'. $a->__get('godina') . '</td><td>'. $a->__get('smjer') . '</td><td>' . $a->__get('ovlasti') .
            '</td><td>' . $mjes[$i][0] . '</td></tr>';
      $i++;
    }
    ?>

    </table>
    <h2 style="clear: both "><br>Odrađeni sati za ovaj tjedan:</h2>
    <table id="popissati">
    <th>Username</th><th>Broj sati</th>
    <?php
      foreach($tjedni as $key => $b)
        echo '<tr><td>'. $key . '</td><td> ' . $b . ' sati</td></tr>';
     ?>
   </table>
   <div style="float: left">
     <form id="satiforma" method="post" action="index.php?rt=adminpostavke/pribrojisate">
       <button name="pribroji" value="">Pribroji mjesečnim satima</button>
     </form>
     <form id="satiforma" method="post" action="index.php?rt=adminpostavke/resetsate">
       <button name="reset" value="">Resetiraj mjesečne sate</button>
     </form>

     <!-- ovo jos treba napravit -->
     <form id="satiforma" method="post" action="index.php?rt=adminpostavke/printsate">
       <button name="print" value="">PDF ispis mjesečnih sati</button>
     </form>
    </div>
</div>

</body>
</html>
