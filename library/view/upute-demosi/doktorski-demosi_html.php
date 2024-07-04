<?php 
if (isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0') {
    require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
} else {
    require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
}
?>
<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-upute-demosi.php'; ?>

<?php require_once __DIR__ . '/../_header.php'; ?>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">
    <h2>Doktorski studij</h2>
    <p>Upute za snimanja na doktorskom studiju:</p>
    <?php 
        $file_path = __DIR__ . '/../../display_upute/doktorski_text.php';
        //$php_content = file_get_contents($file_path);
        include $file_path;
        //echo '<div style="margin-right:25%;">' . htmlspecialchars($php_content) . '</div>';
        
        /* TODO nekad u buducnosti dodati razlicite textboxove
        $directory = __DIR__ . '/../../display_upute/';
        foreach (glob($directory . 'doktorski_text_*.php') as $file) {
            //echo "test";
            $text_content = file_get_contents($file);
            echo '<div style="margin-right:25%;">' . htmlspecialchars($text_content) . '</div>';
        }
        */
    ?>

    <h3>Slike</h3>
    <?php
        $files = glob("view/images/doktorski_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
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
