<?php require_once __DIR__ . '/../_header.php'; ?>

    <form action="<?php echo 'index.php?rt=login/promijenilozinku&sequence=' . $registrationSequence; ?>" method="post">

        <div class="container">
            <label for="psw1"><b>Lozinka</b></label><br>
            <input type="password" placeholder="Unesite lozinku" name="psw1" pattern="^\S*(?=\S{8,})\S*$" title="Lozinka mora biti bar 8 znakova duga!" required>
            <br>
            <label for="psw2"><b>Molim vas ponovite lozinku</b></label><br>
            <input type="password" placeholder="Unesite lozinku" name="psw2" pattern="^\S*(?=\S{8,})\S*$" title="Lozinka mora biti bar 8 znakova duga!" required>
            <br>
            <button class="submitbtn" type="submit">Promijeni lozinku</button>
        </div>

    </form>

</body>

</html>
