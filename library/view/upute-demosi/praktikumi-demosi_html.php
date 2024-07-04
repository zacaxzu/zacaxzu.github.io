<?php 
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-upute-demosi.php'; ?>

<?php require_once __DIR__ . '/../_header.php'; ?>

    <div style="margin-left:25%;padding:1px 16px;height:1000px;">
        <h2>Praktikumi</h2>
        <p>Upute za dežurstva u praktikumima:</p>
        <?php require_once __DIR__ . '/../../display_upute/praktikumi_text.php' ?>
        
        <h3>Slike</h3>
        <?php
            $files = glob("view/images/praktikumi_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
            echo '<div class="gallery-container">';
            foreach ($files as $image) {
                echo '<div class="gallery">';
                    echo '<a target="_blank" href="'. $image . '">';
                        echo '<img src="' . $image . '" alt="Random image" />';
                    echo '</a>';
                echo '<div class="capiton">' . basename($image) . '</div>';
                echo '</div>';
            }
            echo '</div>';
        ?>
    </div>
</body>

</html>
