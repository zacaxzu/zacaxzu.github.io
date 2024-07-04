<?php 
    if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
        require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
    }
    else{
        require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
    }
?>

<?php require_once __DIR__ . '/../_header.php'; ?>

    <h1>Popis svih demosa i njihovi podaci</h1>

    <table id="popissati">
        <th>Ime</th><th>Prezime</th>
        <th>E-mail</th><th>Godina</th><th>Smjer</th>
        <th>Ovlasti</th><th>Broj sati</th>
    <?php
        foreach($users as $user) {
            if ($user->__get('ovlasti')===0){
                $ovlast = 'Admin';
            } else {
                $ovlast = 'Demos';
            }
            echo '<tr>';
            echo '<td>'. $user->__get('ime')  .'</td>';
            echo '<td>'. $user->__get('prezime') . '</td>';
            echo '<td>'. $user->__get('email') . '</td>';
            echo '<td>'. $user->__get('godina') . '</td>';
            echo '<td>'. $user->__get('smjer') . '</td>';
            echo '<td>' . $ovlast .'</td>';?>
                <form action="index.php?rt=users/brojsati" method="post">
			        <td><button type="submit" name="sati" value="<?php echo $user->__get('id');?>">Broj sati</button></td>
                </form>
			<?php
            echo '</tr>';
        }
    ?>

    </table>
</body>
</html>
