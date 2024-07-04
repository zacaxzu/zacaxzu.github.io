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

    <div id="main">
        <h2>Registracija novog demosa</h2>
        <?php if(isset($poruka)) echo $poruka . '<br>' . '<br>';?>
        <form action="index.php?rt=adminpostavke/updatereg" method="post">
            Username:<br>
            <input type="text" name="username" required />
            <br>
            Ime:<br>
            <input type="text" name="ime" required />
            <br>
            Prezime:<br>
            <input type="text" name="prezime" required />
            <br>
            Šifra:<br>
            <input type="password" name="password" pattern="^\S*(?=\S{8,})\S*$"
            title="Šifra mora biti bar 8 znakova duga!" required/>
            <br>
            Ponovno unesite šifru:<br>
            <input type="password" name="password2" pattern="^\S*(?=\S{8,})\S*$"
            title="Šifra mora biti bar 8 znakova duga!" required/>
            <br>
            Email:<br>
            <input type="email" name="email" required/>
            <br>
            Godina studija:<br>
            <select name="godina" required>
                <option value="1"> 1 </option>
                <option value="2"> 2 </option>
                <option value="3"> 3 </option>
                <option value="4"> 4 </option>
                <option value="5"> 5 </option>
            </select>
            <br>
            Smjer:<br>
            <select name="smjer">
                <option value="Prediplomski injženjerski"> Preddiplomski injženjerski </option>
                <option value="Prediplomski nastavnički"> Preddiplomski nastavnički </option>
                <option value="Računarstvo i matematika"> Računarstvo i matematika </option>
                <option value="Teorijska matematika"> Teorijska matematika </option>
                <option value="Primijenjena matematika"> Primijenjena matematika </option>
                <option value="Financijska i poslovna matematika"> Financijska i poslovna matematika </option>
                <option value="Matematička statistika"> Matematička statistika </option>
                <option value="Diplomski nastavnički"> Diplomski nastavnički </option>
                <option value="Diplomski nastavnički matematika i informatika"> Diplomski nastavnički matematika i informatika </option>
                <option value="Biomedmath"> Biomedmath </option>
            </select>
            <br>
            Ovlasti:<br>
            <select name="ovlasti">
                <option value="0"> 0 </option>
                <option value="1"> 1 </option>
            </select>
            <br>
            <button type="submit">
                Spremi promjene
            </button>
        </form>
    </div>
</body>

</html>
