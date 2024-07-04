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

    <h2>Micanje trenutno zaduženih demonstratora</h2>

    <!-- sav CSS za ovo je u novidemos_html.css (razlog je tamo)-->

    <?php
        foreach($demosList as $demos) {
            $email = $demos['email'];
            echo '<div class="micdemosa"><table class="table-style-two"><tr>'
            . '<th>Ime</th><th>Prezime</th><th>Email</th><th>Godina</th><th>Smjer</th><th>Akcija</th></tr>'.
            '<tr><td>'. $demos['ime'] . '</td><td>'. $demos['prezime'] . '</td><td>'. $demos['email']  .
            '</td><td>'. $demos['godina'] . '</td><td>'. $demos['smjer'] . '</td>' .
            '<td><form method="post" action="index.php?rt=adminpostavke/obrisiDemosa"><button class="crven_gumb" name="obrisi" value="'. $email
            .'">Obriši</button></form> </td> </tr> </table> </div> <br>';
        }
        ?>


</div>

</body>
</html>
