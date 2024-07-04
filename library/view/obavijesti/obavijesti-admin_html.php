<?php
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../_header.php'; ?>

<!-- sav CSS za ovo je u galerija_html.css (razlog je tamo)-->

<h1 style="margin-left: 10px">Obavijesti</h1>

<!-- Slijedi prikaz forme u kojoj se moze unjeti nova obavijest-->


<div class="container">
        <h2 id="obavijesti-h2">Dodaj novu obavijest</h2>
        <form class="obavijest-form" method="post" action="index.php?rt=obavijesti/obradiObavijest">
            <div class="obavijest-group">
                <b>Naslov</b>
                <input type="text" id="title" name="naslov_poruke" required>
            </div>
            <div class="obavijest-group">
                <b>Poruka</b>
                <textarea id="message" name="tijelo_poruke" required></textarea>
            </div>
            <div class="obavijest-group">
                <button type="submit" name="btn">Pošalji obavijest</button>
                <button type="reset" name="btn2">Odustani</button>
            </div>
        </form>
    </div>

    <br>
    <br>

    <h2 id="prethodne-h2">Prethodne obavijesti</h2>

<?php
foreach($notifications as $notification){
    // Stvaranje DateTime objekta
    $datetime = new DateTime($notification['datum_objave']);
    // Formatiranje
    $formatted_datetime = $datetime->format('j.n.Y. H:i:s');
    echo '<div class="obavijesti-container">';
    echo '<div class="obavijesti-title">'. $notification['naslov'] .'</div>';
    echo'<div class="obavijesti-date_time"> Datum i vrijeme objave - ' . $formatted_datetime . '</div>';
    echo ' <div class="obavijesti-content">' . $notification['tijelo'] . '</div>';
    echo '</div>';
}
?>

    <!-- za prikaz svih obavijesti -->
    <div class="obavijesti-sve-container">
        <form class="sve-obavijesti-form" method="post" action="index.php?rt=obavijesti/sveObavijesti">
            <button type="submit">Prikaži sve</button>
        </form>
    </div>
