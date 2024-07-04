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

<h2>Ovdje možete upravljati slikama iz podstranice <i>Galerija</i></h2>

<h3>Prijenos slike:</h3>
<form action="index.php?rt=adminPostavke/obradiUpload" method="post" enctype="multipart/form-data" class="upravljanje-form-container">
    <input type="file" name="image" accept="image/*" class="upravljanje-input-file">
    <br>Unesite naziv slike (<b>bez ekstenzije</b>):
    <input type="text" name="nazivslike" required> 
    <button type="submit" name="submit" class="upravljanje-button">Prenesi</button>

    <!-- ovo je zbog toga da ne dobimo warning kako poruka nije definirana -->
    <?php
        if (!isset($upload)) {
            $upload = '';
        }
        if ($upload !== '') {
            echo '<p>' . $upload . '</p>';
        }
    ?>
</form>

<br>

<h3>Brisanje slike:</h3>
<form action="index.php?rt=adminpostavke/obradiDelete" method="post" class="upravljanje-form-container">
    Unesite naziv slike <b>s ekstenzijom</b> koju želite ukloniti sa stranice:
    <input type="text" name="naziv_slike" required> 
    <button type="submit" name="submit" class="upravljanje-button">Obriši</button>
    <br>
    (Pogledati na podstranicu <i>Galerija</i> za naziv i ekstenziju)

    <?php
        if (!isset($brisanje)) {
            $brisanje = '';
        }
        if ($brisanje !== '') {
            echo '<p>' . $brisanje . '</p>';
        }
    ?>
</form>

</div>

</body>
</html>