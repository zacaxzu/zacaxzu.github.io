<?php 
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../_header.php'; ?>


<h1>Obavijesti</h1>

<h2 id="prethodne-h2">Popis aktualnih obavijesti</h2>

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