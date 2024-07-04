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

<h2 id="prethodne-h2">Sve obavijesti</h2>

    <!-- povratak na prethodno -->
    <div class="obavijesti-sve-container2">
        <form class="sve-obavijesti-form" method="post" action="index.php?rt=obavijesti/index">
            <button type="submit">Povratak na prethodnu</button>
        </form>
    </div>

<?php
foreach($allNotifications as $allNotification){
    $datetime = new DateTime($allNotification['datum_objave']);
    $formatted_datetime = $datetime->format('j.n.Y. H:i:s');  
    echo '<div class="obavijesti-container">';
    echo '<div class="obavijesti-title">'. $allNotification['naslov'] .'</div>';
    echo'<div class="obavijesti-date_time"> Datum i vrijeme objave - ' . $formatted_datetime . '</div>';
    echo ' <div class="obavijesti-content">' . $allNotification['tijelo'] . '</div>';
    echo '</div>';
}
?>

