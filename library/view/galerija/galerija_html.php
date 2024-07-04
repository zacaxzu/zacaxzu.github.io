<?php 
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../_header.php'; ?>


<h1 id="naslov-galerija">&#128247 Dobrodošli u galeriju &#128247</h1>


<!-- slijedi kod za prikaz uploadanih slika -->
<?php
$files = glob("view/images/slike_galerija/*.{jpg,jpeg,png}", GLOB_BRACE);
foreach ($files as $image) {
    echo '<div class="galerija-responsive">';
    echo '<div class="galerija">';
    echo '<img src="' . $image . '" alt="Cinque Terre">';
    echo '<div class="galerija-desc">' . basename($image) . '</div>';
    echo '</div>';
    echo '</div>';
}
echo '<div class="clearfix"></div>';
?>

<br>

<div class="galerija-alert">
  <span class="galerija-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Ako želite da i Vaša slika bude zabilježena u galeriji molimo javite se voditeljima stranice.
</div>

<!-- <h3><strong>Info: </strong>Ako želite da i Vaša slika bude zabilježena u galeriji molimo javite se voditelju stranice</h3> -->

<br>
</body>
</html>