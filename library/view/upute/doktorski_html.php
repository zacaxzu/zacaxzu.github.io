<?php 
if(isset($_COOKIE['ovlasti']) && $_COOKIE['ovlasti'] === '0'){
    require_once __DIR__ . '/../navigation-bars/navigation-bar-admin.php';
}
else{
    require_once __DIR__ . '/../navigation-bars/navigation-bar.php';
}
?>
<?php require_once __DIR__ . '/../navigation-bars/navigation-bar-upute.php'; ?>
<?php require_once __DIR__ . '/../_header.php'; ?>

<div style="margin-left:25%;padding:1px 16px;height:1000px;">
    <h2>Doktorski studij</h2>
    <p>Molim vas koristite prelazak u novi red radi ljepšeg ispisa.</p>
    <?php if (!empty($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="post" action="index.php?rt=upute/doktorski" enctype="multipart/form-data">
        <label for="edited_content">Upute za snimanja na doktorskom studiju:</label><br>
        <textarea id="edited_content" name="edited_content" rows="10" cols="50"><?php echo htmlspecialchars($php_content); ?></textarea><br>
        <!--

        TODO Dodavanje vise textboxeva

        <div id="additional_fields">
            <?php
            //echo "test";
            // Ucitamo preostale fileove teksta
            /*$directory = __DIR__ . '/../../display_upute/';
            foreach (glob($directory . 'doktorski_text_*.php') as $file) {
                $text_content = file_get_contents($file);
                //echo 'test';
                echo '<div id="' . basename($file, ".php") . '">
                        <textarea id="additional_texts[]" name="additional_texts[]" rows="10" cols="50">' . htmlspecialchars($text_content) . '</textarea>
                        <button type="button" onclick="moveUp(\'' . basename($file, ".php") . '\')">Pomakni gore</button>
                        <button type="button" onclick="moveDown(\'' . basename($file, ".php") . '\')">Pomakni dolje</button>
                        <button type="button" onclick="removeField(\'' . basename($file, ".php") . '\')">Makni</button>
                        <button type="button" onclick="deleteField(\'' . basename($file) . '\')">Obiši</button>
                        <input type="hidden" name="file_names[]" value="' . basename($file) . '">
                      </div><br>';
            }*/
            ?>
        </div>
        -->
        <!--
        <button type="button" onclick="addTextbox()">Add Textbox</button>
        <button type="button" onclick="addPhoto()">Add Photo</button><br>
        -->
        <button type="submit" value="Save">Spremi promjene</button>
    </form>

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

    <br>

    <h4>Ovdje možete upravljati gornjim slikama:</h4>
    <form action="index.php?rt=upute/doktorskiSlikeUplaod" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <?php echo '<br>' . 'Unesite naziv slike (bez ekstenzije):'; ?>
        <input type="text" name="nazivslike" required> 
        <button type="submit" name="submit">Prenesi</button>

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

    <br><br>

    <form action="index.php?rt=upute/doktorskiSlikeDelete" method="post">
        <?php echo '<br>' . 'Unesite naslov slike (s ekstenzijom) koju želite ukloniti sa stranice: '; ?>
        <input type="text" name="naziv_slike" required> 
        <button type="submit" name="submit">Obriši</button>
        <br>

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

<script>
    // Editor texta
    //TODO Dodati velicinu fonta nekad u buducnosti
    ClassicEditor
        .create(document.querySelector('#edited_content'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'blockQuote',
                    'numberedList',
                    'undo',
                    'redo'
                ],
            },
            // Micanje uplaoda slika
            removePlugins: ['CKFinderUploadAdapter', 'bulletedList', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
        })
        .catch( error => {
                console.error( error );
            } 
        );        
</script>

<!--- // TODO Napraviti dodavanje textboxova nekad u buducnosti
<script>
    let fieldCount = <?php //echo count(glob($directory . 'doktorski_text_*.php')) + 1; ?>;

    function addTextbox() {
        fieldCount++;
        const div = document.createElement('div');
        div.id = 'field_' + fieldCount;
        div.innerHTML = `
            <textarea name="new_additional_texts[]" rows="10" cols="50"></textarea>
            <button type="button" onclick="moveUp('field_${fieldCount}')">Pomakni gore</button>
            <button type="button" onclick="moveDown('field_${fieldCount}')">Pomakni dolje</button>
            <button type="button" onclick="removeField('field_${fieldCount}')">Obiši</button>
            <br>`;
        document.getElementById('additional_fields').appendChild(div);
    }

    function addPhoto() {
        fieldCount++;
        const div = document.createElement('div');
        div.id = 'field_' + fieldCount;
        div.innerHTML = `
            <input type="file" name="additional_photos[]">
            <button type="button" onclick="moveUp('field_${fieldCount}')">Pomakni gore</button>
            <button type="button" onclick="moveDown('field_${fieldCount}')">Pomakni dolje</button>
            <button type="button" onclick="removeField('field_${fieldCount}')">Obiši</button>
            <br>`;
        document.getElementById('additional_fields').appendChild(div);
    }

    function removeField(id) {
        const field = document.getElementById(id);
        if (field) {
            field.remove();
        }
    }

    function moveUp(id) {
        const field = document.getElementById(id);
        if (field && field.previousElementSibling) {
            field.parentNode.insertBefore(field, field.previousElementSibling);
        }
    }

    function moveDown(id) {
        const field = document.getElementById(id);
        if (field && field.nextElementSibling) {
            field.parentNode.insertBefore(field.nextElementSibling, field);
        }
    }

    function deleteField(file) {
        const confirmed = confirm("Jeste li sigurni da želite obrisati taj textbox?");
        if (confirmed) {
            fetch(`index.php?rt=upute/deleteFile&file=${file}`, { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const field = document.getElementById(file.replace(".php", ""));
                        if (field) {
                            field.remove();
                        }
                    } else {
                        alert("Greška pri brisanju slike.");
                    }
                });
        }
    }
</script>
-->
