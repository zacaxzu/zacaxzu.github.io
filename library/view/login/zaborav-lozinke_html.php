<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-login.php'; ?>

<?php require_once __DIR__ . '/../_header.php'; ?>

    <form action="index.php?rt=login/slanjemaila" method="post">

        <div class="container">
            <label for="uname"><b>Unesite vaš email te će vam bit poslan vaš username i link preko kojeg možete promijeniti lozinku::</b></label><br>
            <input type="text" placeholder="Unesite vaš email" name="email" required>
            <br>
            <button class="submitbtn" type="submit">Pošalji email</button>
            <br>
        </div>

    </form>

<?php require_once __DIR__ . '/../_footer.php'; ?>
