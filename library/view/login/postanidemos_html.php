<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-login.php'; ?>

<?php require_once __DIR__ . '/../_header.php'; ?>

    <div class="forma">
        <form action="index.php?rt=postanidemos/obradi" method="post">
            <label for="fname">Ime</label><br>
            <input type="text" id="fname" name="firstname" placeholder="Goran..." required> <br>

            <label for="lname">Prezime</label><br>
            <input type="text" id="lname" name="lastname" placeholder="Igaly..." required><br>

            <label for="brmoba">Broj mobitela</label><br>
            <input type="text" id="brmoba" name="brojmobitela" placeholder="097 1237 813..." required><br>

            <label for="faksmail">Mail (od fakulteta)</label><br>
            <input type="text" id="faksmail" name="mailfaksa" placeholder="korisnickoime.math@pmf.hr..." required><br>

            <label for="osobnimail">Mail (npr. gmail)</label><br>
            <input type="text" id="osobnimail" name="mailosobni" placeholder="ime.prezime@gmail.com..."><br>

            <label for="kolegiji">Imate li nepoloženih kolegija na prvoj godini preddiplomskog studija?
            </label> <br>
            <input type="radio" name="polozeno" id="da" value="Da" required/> Da
            <input type="radio" name="polozeno" id="ne" value="Ne" /> Ne <br>

            <label for="godina">Godina studija</label><br>
            <select id="godina" name="godina">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select><br>

            <label for="smjer">Smjer</label><br>
            <select id="smjer" name="smjer">
                <option value="dipl-rac">Računarstvo</option>
                <option value="dipl-stat">Statistika</option>
                <option value="dipl-prim">Primjenjena</option>
                <option value="dipl-teor">Teorijska</option>
                <option value="dipl-fin">Financijska</option>
                <option value="dipl-biomedmath">BioMedMath</option>
                <option value="dipl-nast">Matematika (nastavnički)</option>
                <option value="dipl-matinf">Matematika i informatika (nastavnički)</option>
                <option value="integ-matfiz">Matematika i fizika (integrirani)</option>
                <option value="preddipl-inz">Inženjerski (preddiplomski)</option>
                <option value="preddipl-nast">Nastavnički (preddiplomski)</option>
            </select><br>

            <label for="termini">Molimo označite termine u kojima smatrate da ćete biti dostupni za odrađivanje demonstratorskih obaveza za vrijeme zimskog semestra 2022./2023. To ne znači da će od vas biti traženo da radite sve termine već da znamo kada možemo računati na vas. Označite minimalno 6 sati.
                Prednost imaju oni koji imaju više slobodnih termina.</label><br>

            <table>
                <tr>
                    <td></td>
                    <td>PONEDJELJAK</td>
                    <td>UTORAK</td>
                    <td>SRIJEDA</td>
                    <td>ČETVRTAK</td>
                    <td>PETAK</td>
                </tr>
                <tr>
                    <td>8:00 - 9:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="8:00-9:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="8:00-9:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="8:00-9:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="8:00-9:00"></td>
                    <td><input type="checkbox" name="petak[]" value="8:00-9:00"></td>
                </tr>
                <tr>
                    <td>9:00 - 10:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="9:00-10:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="9:00-10:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="9:00-10:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="9:00-10:00"></td>
                    <td><input type="checkbox" name="petak[]" value="9:00-10:00"></td>
                </tr>
                <tr>
                    <td>10:00 - 11:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="10:00-11:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="10:00-11:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="10:00-11:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="10:00-11:00"></td>
                    <td><input type="checkbox" name="petak[]" value="10:00-11:00"></td>
                </tr>
                <tr>
                    <td>11:00 - 12:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="11:00-12:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="11:00-12:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="11:00-12:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="11:00-12:00"></td>
                    <td><input type="checkbox" name="petak[]" value="11:00-12:00"></td>
                </tr>
                <tr>
                    <td>12:00 - 13:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="12:00-13:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="12:00-13:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="12:00-13:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="12:00-13:00"></td>
                    <td><input type="checkbox" name="petak[]" value="12:00-13:00"></td>
                </tr>
                <tr>
                    <td>13:00 - 14:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="13:00-14:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="13:00-14:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="13:00-14:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="13:00-14:00"></td>
                    <td><input type="checkbox" name="petak[]" value="13:00-14:00"></td>
                </tr>
                <tr>
                    <td>14:00 - 15:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="14:00-15:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="14:00-15:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="14:00-15:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="14:00-15:00"></td>
                    <td><input type="checkbox" name="petak[]" value="14:00-15:00"></td>
                </tr>
                <tr>
                    <td>15:00 - 16:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="15:00-16:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="15:00-16:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="15:00-16:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="15:00-16:00"></td>
                    <td><input type="checkbox" name="petak[]" value="15:00-16:00"></td>
                </tr>
                <tr>
                    <td>16:00 - 17:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="16:00-17:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="16:00-17:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="16:00-17:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="16:00-17:00"></td>
                    <td><input type="checkbox" name="petak[]" value="16:00-17:00"></td>
                </tr>
                <tr>
                    <td>17:00 - 18:00</td>
                    <td><input type="checkbox" name="ponedjeljak[]" value="17:00-18:00"></td>
                    <td><input type="checkbox" name="utorak[]" value="17:00-18:00"></td>
                    <td><input type="checkbox" name="srijeda[]" value="17:00-18:00"></td>
                    <td><input type="checkbox" name="cetvrtak[]" value="17:00-18:00"></td>
                    <td><input type="checkbox" name="petak[]" value="17:00-18:00"></td>
                </tr>
            </table>

            <label for="kolegiji">Kako ste saznali za ovaj posao? </label> <br>
            <input type="radio" name="poziv" id="" value="Preko starijih demonstratora" /> Preko starijih demonstratora <br>
            <input type="radio" name="poziv" id="" value="Preko profesora/asistenata" /> Preko profesora/asistenata <br>
            <input type="radio" name="poziv" id="" value="Preko oglasa" /> Preko oglasa <br>
            <input type="radio" name="poziv" id="" value="Ostalo" /> Ostalo:
            <input type="text" name="poziv-ostalo"> <br>

            <label for="">Napomene</label> <br>
            <input type="text" name="napomene" id="" /> <br>

            <button type="submit" value="Submit">Submit</button>
        </form>
        <?php
        if (!isset($poruka)) {
            $poruka = '';
        }
        if ($poruka !== '') {
            echo '<p>' . $poruka . '</p>';
        }
        ?>
    </div>

<?php require_once __DIR__ . '/../_footer.php'; ?>
