<?php 
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>
<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-postavke.php'; ?>

<?php require_once __DIR__ . '/../_header.php'; ?>


  <?php

  require_once __DIR__ . '/account_html.php';
  ?>
</body>

</html>
