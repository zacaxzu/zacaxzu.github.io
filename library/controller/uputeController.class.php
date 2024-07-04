<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class UputeController
{
    private $libraryService;

    public function __construct()
    {
        $this->libraryService = new LibraryService();
    }
    
    public function index()
    {
        require_once __DIR__ . '/../view/login/login_html.php';
    }

    public function aktuarski()
    {
        $file_path = __DIR__ . '/../display_upute/aktuarski_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);

        if (isset($_POST['edited_content'])) {
            $content = $_POST['edited_content'];

            if ($this->libraryService->saveFileContent($file_path, $content)) {
                $php_content = $this->libraryService->getFileContent($file_path);
                require_once 'view/upute/aktuarski_html.php';
            } else {
                require_once 'view/upute/aktuarski_html.php';
            }
        } else {
            require_once 'view/upute/aktuarski_html.php';
        }
    }

    public function aktuarskiSlikeUplaod()
    {
        //provjera postoji li nešto u submit
        if(isset($_POST['submit']))
        {
            $file_path = __DIR__ . '/../display_upute/aktuarski_text.php';
            $php_content = $this->libraryService->getFileContent($file_path);
            if($_FILES['image']['error'] === 0)
            {
                $image = $_FILES['image'];
                $nazivSlike = $_POST['nazivslike'];

                $imageFileType=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                //navodimo koji su tipovi dozvoljeni
                $allowedTypes = array('jpg', 'jpeg', 'png');

                if(in_array($imageFileType, $allowedTypes))
                {   
                    //generiramo ime za sliku
                    $imageName = $nazivSlike . '.' . $imageFileType; 

                    //moramo provjeriti naziv slike
                    $files = glob("view/images/aktuarski_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
                    foreach ($files as $file) {
                        if( $imageName === basename($file)){ 
                            $upload = 'Slika s tim nazivom već postoji, molimo Vas odaberite neki drugi naziv!';
                            require_once 'view/upute/aktuarski_html.php';
                            return;
                        }
                    }
                    //spremamo sliku o odgovarajući direktorij (u ovom slučaju view/images/slike_galerija)
                    move_uploaded_file($image['tmp_name'],dirname(__FILE__) . '/../view/images/aktuarski_upute/' . $imageName);
                    $upload = 'Uspješno ste prenjeli sliku!';
                    header('Location: index.php?rt=upute/aktuarskiUspjesanPrijenos'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
                    exit;
                }
                else
                {
                    $upload = 'Dozovljeni su formati .jpg, .jpeg i .png, provjerite Vaš format slike.';
                    require_once 'view/upute/aktuarski_html.php';
                    return;
                }
            }
            else
            {
                 // Ispis grešaka koje se mogu dogoditi!
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $upload = 'Veličina slike premašuje dozvoljenu veličinu.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $upload = 'Slika je djelomično prenesena.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $upload = 'Nijedna slika nije prenesena.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $upload = 'Prijenos slike zaustavljen zbog ekstenzije.';
                    break;
                default:
                    $upload = 'Došlo je do greške prilikom uploada slike.';
                    break;
            }
            require_once 'view/upute/aktuarski_html.php';
            return;
            }
        }
    }

    public function aktuarskiUspjesanPrijenos()
    {
        $file_path = __DIR__ . '/../display_upute/aktuarski_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        $upload = 'Uspješno ste prenijeli sliku!';
        require_once 'view/upute/aktuarski_html.php';
        return;
    }

    public function aktuarskiSlikeDelete()
    {
        $file_path = __DIR__ . '/../display_upute/aktuarski_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        if(isset($_POST['submit']))
        {
            $nazivSlike = $_POST['naziv_slike'];
            //putanja do slike
            $imagePath = dirname(__FILE__) . '/../view/images/aktuarski_upute/' . $nazivSlike;
        
            if(file_exists($imagePath))
            {
                if(unlink($imagePath)) //ovo omogucava brisanje unlink()
                {
                    $brisanje = 'Slika je uspješno uklonjena!';
                    require_once 'view/upute/aktuarski_html.php';
                    return;
                }
                else
                {
                    $brisanje = 'Došlo je do greške prilikom brisanja slike!';
                    require_once 'view/upute/aktuarski_html.php';
                    return;
                }
            }
            else
            {
                $brisanje = 'Slika tog naslova ne postoji, probajte ponovno (u naslov mora biti uključeno sve)';
                require_once 'view/upute/aktuarski_html.php';
                return;
            }
        }
        require_once 'view/upute/aktuarski_html.php';
        return;
    }

    public function aktuarskidemosi()
    {
        require_once __DIR__ . '/../view/upute-demosi/aktuarski-demosi_html.php';
    }

    public function doktorski()
    {
        $file_path = __DIR__ . '/../display_upute/doktorski_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);

        if (isset($_POST['edited_content'])) {
            $content = $_POST['edited_content'];

            // Spremanje texta
            if ($this->libraryService->saveFileContent($file_path, $content)) {
                $php_content = $this->libraryService->getFileContent($file_path);
            } else {
                $error_message = 'Greška u spremanju.';
            }

            // Spremanje svih text inputa osim prvog osnovnog
            /*if (!empty($_POST['additional_texts']) && !empty($_POST['file_names'])) {
                foreach ($_POST['additional_texts'] as $index => $additional_text) {
                    $file_name = $_POST['file_names'][$index];
                    $file_path = __DIR__ . '/../display_upute/' . $file_name;
                    $this->libraryService->saveFileContent($file_path, $additional_text);
                }
            }

            // Novi text inputa
            if (!empty($_POST['new_additional_texts'])) {
                $counter = count(glob(__DIR__ . '/../display_upute/doktorski_text_*.php')) + 1;
                foreach ($_POST['new_additional_texts'] as $new_text) {
                    $file_name = 'doktorski_text_' . $counter . '.php';
                    $file_path = __DIR__ . '/../display_upute/' . $file_name;
                    $this->libraryService->saveFileContent($file_path, $new_text);
                    $counter++;
                }
            }

            // Uplaod slika
            if (!empty($_FILES['additional_photos']['name'][0])) {
                $upload_dir = __DIR__ . '/../images/doktorski_upute/';
                foreach ($_FILES['additional_photos']['name'] as $key => $filename) {
                    if ($_FILES['additional_photos']['error'][$key] == UPLOAD_ERR_OK) {
                        $upload_file = $upload_dir . basename($filename);
                        if (move_uploaded_file($_FILES['additional_photos']['tmp_name'][$key], $upload_file)) {
                            $image_url = 'images/' . basename($filename);
                            $content .= '<img src="' . htmlspecialchars($image_url) . '" alt="Uploaded Image">';
                        }
                    }
                }
            }*/

            // RPonovno ucitamo formu
            require_once 'view/upute/doktorski_html.php';
        } else {
            require_once 'view/upute/doktorski_html.php';
        }
    }

    // Funkcija za brisanje filova koja se nije koristila na kraju
    /*public function deleteFile()
    {
        //echo "test";
        if (isset($_POST['file'])) {
            $file = basename($_POST['file']);
            echo "test";
            $file_path = __DIR__ . '/../display_upute/' . $file;

            if (file_exists($file_path) && unlink($file_path)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }*/

    public function doktorskiSlikeUplaod()
    {
        //provjera postoji li nešto u submit
        if(isset($_POST['submit']))
        {
            $file_path = __DIR__ . '/../display_upute/doktorski_text.php';
            $php_content = $this->libraryService->getFileContent($file_path);
            if($_FILES['image']['error'] === 0)
            {
                $image = $_FILES['image'];
                $nazivSlike = $_POST['nazivslike'];

                $imageFileType=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                //navodimo koji su tipovi dozvoljeni
                $allowedTypes = array('jpg', 'jpeg', 'png');

                if(in_array($imageFileType, $allowedTypes))
                {   
                    //generiramo ime za sliku
                    $imageName = $nazivSlike . '.' . $imageFileType; 

                    //moramo provjeriti naziv slike
                    $files = glob("view/images/doktorski_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
                    foreach ($files as $file) {
                        if( $imageName === basename($file)){ 
                            $upload = 'Slika s tim nazivom već postoji, molimo Vas odaberite neki drugi naziv!';
                            require_once 'view/upute/doktorski_html.php';
                            return;
                        }
                    }
                    //spremamo sliku o odgovarajući direktorij (u ovom slučaju view/images/slike_galerija)
                    move_uploaded_file($image['tmp_name'],dirname(__FILE__) . '/../view/images/doktorski_upute/' . $imageName);
                    $upload = 'Uspješno ste prenjeli sliku!';
                    header('Location: index.php?rt=upute/doktorskiUspjesanPrijenos'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
                    exit;
                }
                else
                {
                    $upload = 'Dozovljeni su formati .jpg, .jpeg i .png, provjerite Vaš format slike.';
                    require_once 'view/upute/doktorski_html.php';
                    return;
                }
            }
            else
            {
                 // Ispis grešaka koje se mogu dogoditi!
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $upload = 'Veličina slike premašuje dozvoljenu veličinu.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $upload = 'Slika je djelomično prenesena.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $upload = 'Nijedna slika nije prenesena.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $upload = 'Prijenos slike zaustavljen zbog ekstenzije.';
                    break;
                default:
                    $upload = 'Došlo je do greške prilikom uploada slike.';
                    break;
            }
            require_once 'view/upute/doktorski_html.php';
            return;
            }
        }
    }

    public function doktorskiUspjesanPrijenos()
    {
        $file_path = __DIR__ . '/../display_upute/doktorski_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        $upload = 'Uspješno ste prenijeli sliku!';
        require_once 'view/upute/doktorski_html.php';
        return;
    }

    public function doktorskiSlikeDelete()
    {
        $file_path = __DIR__ . '/../display_upute/doktorski_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        if(isset($_POST['submit']))
        {
            $nazivSlike = $_POST['naziv_slike'];
            //putanja do slike
            $imagePath = dirname(__FILE__) . '/../view/images/doktorski_upute/' . $nazivSlike;
        
            if(file_exists($imagePath))
            {
                if(unlink($imagePath)) //ovo omogucava brisanje unlink()
                {
                    $brisanje = 'Slika je uspješno uklonjena!';
                    require_once 'view/upute/doktorski_html.php';
                    return;
                }
                else
                {
                    $brisanje = 'Došlo je do greške prilikom brisanja slike!';
                    require_once 'view/upute/doktorski_html.php';
                    return;
                }
            }
            else
            {
                $brisanje = 'Slika tog naslova ne postoji, probajte ponovno (u naslov mora biti uključeno sve)';
                require_once 'view/upute/doktorski_html.php';
                return;
            }
        }
        require_once 'view/upute/doktorski_html.php';
        return;
    }

    public function doktorskidemosi()
    {
        require_once __DIR__ . '/../view/upute-demosi/doktorski-demosi_html.php';
    }

    public function praktikumi()
    {
        $file_path = __DIR__ . '/../display_upute/praktikumi_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);

        if (isset($_POST['edited_content'])) {
            $content = $_POST['edited_content'];

            if ($this->libraryService->saveFileContent($file_path, $content)) {
                $php_content = $this->libraryService->getFileContent($file_path);
                require_once 'view/upute/praktikumi_html.php';
            } else {
                require_once 'view/upute/praktikumi_html.php';
            }
        } else {
            require_once 'view/upute/praktikumi_html.php';
        }
    }

    public function praktikumiSlikeUplaod()
    {
        //provjera postoji li nešto u submit
        if(isset($_POST['submit']))
        {
            $file_path = __DIR__ . '/../display_upute/praktikumi_text.php';
            $php_content = $this->libraryService->getFileContent($file_path);
            if($_FILES['image']['error'] === 0)
            {
                $image = $_FILES['image'];
                $nazivSlike = $_POST['nazivslike'];

                $imageFileType=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                //navodimo koji su tipovi dozvoljeni
                $allowedTypes = array('jpg', 'jpeg', 'png');

                if(in_array($imageFileType, $allowedTypes))
                {   
                    //generiramo ime za sliku
                    $imageName = $nazivSlike . '.' . $imageFileType; 

                    //moramo provjeriti naziv slike
                    $files = glob("view/images/praktikumi_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
                    foreach ($files as $file) {
                        if( $imageName === basename($file)){ 
                            $upload = 'Slika s tim nazivom već postoji, molimo Vas odaberite neki drugi naziv!';
                            require_once 'view/upute/praktikumi_html.php';
                            return;
                        }
                    }
                    //spremamo sliku o odgovarajući direktorij (u ovom slučaju view/images/slike_galerija)
                    move_uploaded_file($image['tmp_name'],dirname(__FILE__) . '/../view/images/praktikumi_upute/' . $imageName);
                    $upload = 'Uspješno ste prenjeli sliku!';
                    header('Location: index.php?rt=upute/praktikumiUspjesanPrijenos'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
                    exit;
                }
                else
                {
                    $upload = 'Dozovljeni su formati .jpg, .jpeg i .png, provjerite Vaš format slike.';
                    require_once 'view/upute/praktikumi_html.php';
                    return;
                }
            }
            else
            {
                 // Ispis grešaka koje se mogu dogoditi!
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $upload = 'Veličina slike premašuje dozvoljenu veličinu.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $upload = 'Slika je djelomično prenesena.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $upload = 'Nijedna slika nije prenesena.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $upload = 'Prijenos slike zaustavljen zbog ekstenzije.';
                    break;
                default:
                    $upload = 'Došlo je do greške prilikom uploada slike.';
                    break;
            }
            require_once 'view/upute/praktikumi_html.php';
            return;
            }
        }
    }

    public function praktikumiUspjesanPrijenos()
    {
        $file_path = __DIR__ . '/../display_upute/praktikumi_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        $upload = 'Uspješno ste prenijeli sliku!';
        require_once 'view/upute/praktikumi_html.php';
        return;
    }

    public function praktikumiSlikeDelete()
    {
        $file_path = __DIR__ . '/../display_upute/praktikumi_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        if(isset($_POST['submit']))
        {
            $nazivSlike = $_POST['naziv_slike'];
            //putanja do slike
            $imagePath = dirname(__FILE__) . '/../view/images/praktikumi_upute/' . $nazivSlike;
        
            if(file_exists($imagePath))
            {
                if(unlink($imagePath)) //ovo omogucava brisanje unlink()
                {
                    $brisanje = 'Slika je uspješno uklonjena!';
                    require_once 'view/upute/praktikumi_html.php';
                    return;
                }
                else
                {
                    $brisanje = 'Došlo je do greške prilikom brisanja slike!';
                    require_once 'view/upute/praktikumi_html.php';
                    return;
                }
            }
            else
            {
                $brisanje = 'Slika tog naslova ne postoji, probajte ponovno (u naslov mora biti uključeno sve)';
                require_once 'view/upute/praktikumi_html.php';
                return;
            }
        }
        require_once 'view/upute/praktikumi_html.php';
        return;
    }

    public function praktikumidemosi() 
    {
        require_once __DIR__ . '/../view/upute-demosi/praktikumi-demosi_html.php';
    }

    public function printanje()
    {
        $file_path = __DIR__ . '/../display_upute/printanje_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);

        if (isset($_POST['edited_content'])) {
            $content = $_POST['edited_content'];

            if ($this->libraryService->saveFileContent($file_path, $content)) {
                $php_content = $this->libraryService->getFileContent($file_path);
                require_once 'view/upute/printanje_html.php';
            } else {
                require_once 'view/upute/printanje_html.php';
            }
        } else {
            require_once 'view/upute/printanje_html.php';
        }
    }

    public function printanjeSlikeUplaod()
    {
        //provjera postoji li nešto u submit
        if(isset($_POST['submit']))
        {
            $file_path = __DIR__ . '/../display_upute/printanje_text.php';
            $php_content = $this->libraryService->getFileContent($file_path);
            if($_FILES['image']['error'] === 0)
            {
                $image = $_FILES['image'];
                $nazivSlike = $_POST['nazivslike'];

                $imageFileType=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                //navodimo koji su tipovi dozvoljeni
                $allowedTypes = array('jpg', 'jpeg', 'png');

                if(in_array($imageFileType, $allowedTypes))
                {   
                    //generiramo ime za sliku
                    $imageName = $nazivSlike . '.' . $imageFileType; 

                    //moramo provjeriti naziv slike
                    $files = glob("view/images/printanje_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
                    foreach ($files as $file) {
                        if( $imageName === basename($file)){ 
                            $upload = 'Slika s tim nazivom već postoji, molimo Vas odaberite neki drugi naziv!';
                            require_once 'view/upute/printanje_html.php';
                            return;
                        }
                    }
                    //spremamo sliku o odgovarajući direktorij (u ovom slučaju view/images/slike_galerija)
                    move_uploaded_file($image['tmp_name'],dirname(__FILE__) . '/../view/images/printanje_upute/' . $imageName);
                    $upload = 'Uspješno ste prenjeli sliku!';
                    header('Location: index.php?rt=upute/printanjeUspjesanPrijenos'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
                    exit;
                }
                else
                {
                    $upload = 'Dozovljeni su formati .jpg, .jpeg i .png, provjerite Vaš format slike.';
                    require_once 'view/upute/printanje_html.php';
                    return;
                }
            }
            else
            {
                 // Ispis grešaka koje se mogu dogoditi!
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $upload = 'Veličina slike premašuje dozvoljenu veličinu.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $upload = 'Slika je djelomično prenesena.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $upload = 'Nijedna slika nije prenesena.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $upload = 'Prijenos slike zaustavljen zbog ekstenzije.';
                    break;
                default:
                    $upload = 'Došlo je do greške prilikom uploada slike.';
                    break;
            }
            require_once 'view/upute/printanje_html.php';
            return;
            }
        }
    }

    public function printanjeUspjesanPrijenos()
    {
        $file_path = __DIR__ . '/../display_upute/printanje_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        $upload = 'Uspješno ste prenijeli sliku!';
        require_once 'view/upute/printanje_html.php';
        return;
    }

    public function printanjeSlikeDelete()
    {
        $file_path = __DIR__ . '/../display_upute/printanje_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        if(isset($_POST['submit']))
        {
            $nazivSlike = $_POST['naziv_slike'];
            //putanja do slike
            $imagePath = dirname(__FILE__) . '/../view/images/printanje_upute/' . $nazivSlike;
        
            if(file_exists($imagePath))
            {
                if(unlink($imagePath)) //ovo omogucava brisanje unlink()
                {
                    $brisanje = 'Slika je uspješno uklonjena!';
                    require_once 'view/upute/printanje_html.php';
                    return;
                }
                else
                {
                    $brisanje = 'Došlo je do greške prilikom brisanja slike!';
                    require_once 'view/upute/printanje_html.php';
                    return;
                }
            }
            else
            {
                $brisanje = 'Slika tog naslova ne postoji, probajte ponovno (u naslov mora biti uključeno sve)';
                require_once 'view/upute/printanje_html.php';
                return;
            }
        }
        require_once 'view/upute/printanje_html.php';
        return;
    }

    public function printanjedemosi()
    {
        require_once __DIR__ . '/../view/upute-demosi/printanje-demosi_html.php';
    }

    public function snimanje()
    {
        $file_path = __DIR__ . '/../display_upute/snimanje_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);

        if (isset($_POST['edited_content'])) {
            $content = $_POST['edited_content'];

            if ($this->libraryService->saveFileContent($file_path, $content)) {
                $php_content = $this->libraryService->getFileContent($file_path);
                require_once 'view/upute/snimanje_html.php';
            } else {
                require_once 'view/upute/snimanje_html.php';
            }
        } else {
            require_once 'view/upute/snimanje_html.php';
        }
    }

    public function snimanjeSlikeUplaod()
    {
        //provjera postoji li nešto u submit
        if(isset($_POST['submit']))
        {
            $file_path = __DIR__ . '/../display_upute/snimanje_text.php';
            $php_content = $this->libraryService->getFileContent($file_path);
            if($_FILES['image']['error'] === 0)
            {
                $image = $_FILES['image'];
                $nazivSlike = $_POST['nazivslike'];

                $imageFileType=strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                //navodimo koji su tipovi dozvoljeni
                $allowedTypes = array('jpg', 'jpeg', 'png');

                if(in_array($imageFileType, $allowedTypes))
                {   
                    //generiramo ime za sliku
                    $imageName = $nazivSlike . '.' . $imageFileType; 

                    //moramo provjeriti naziv slike
                    $files = glob("view/images/snimanje_upute/*.{jpg,jpeg,png}", GLOB_BRACE);
                    foreach ($files as $file) {
                        if( $imageName === basename($file)){ 
                            $upload = 'Slika s tim nazivom već postoji, molimo Vas odaberite neki drugi naziv!';
                            require_once 'view/upute/snimanje_html.php';
                            return;
                        }
                    }
                    //spremamo sliku o odgovarajući direktorij (u ovom slučaju view/images/slike_galerija)
                    move_uploaded_file($image['tmp_name'],dirname(__FILE__) . '/../view/images/snimanje_upute/' . $imageName);
                    $upload = 'Uspješno ste prenjeli sliku!';
                    header('Location: index.php?rt=upute/snimanjeUspjesanPrijenos'); //ovo ce usmjeriti na posebno kreiranu funkciju uspjesanPrijenos->detaljno ispod
                    exit;
                }
                else
                {
                    $upload = 'Dozovljeni su formati .jpg, .jpeg i .png, provjerite Vaš format slike.';
                    require_once 'view/upute/snimanje_html.php';
                    return;
                }
            }
            else
            {
                 // Ispis grešaka koje se mogu dogoditi!
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $upload = 'Veličina slike premašuje dozvoljenu veličinu.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $upload = 'Slika je djelomično prenesena.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $upload = 'Nijedna slika nije prenesena.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $upload = 'Prijenos slike zaustavljen zbog ekstenzije.';
                    break;
                default:
                    $upload = 'Došlo je do greške prilikom uploada slike.';
                    break;
            }
            require_once 'view/upute/snimanje_html.php';
            return;
            }
        }
    }

    public function snimanjeUspjesanPrijenos()
    {
        $file_path = __DIR__ . '/../display_upute/snimanje_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        $upload = 'Uspješno ste prenijeli sliku!';
        require_once 'view/upute/snimanje_html.php';
        return;
    }

    public function snimanjeSlikeDelete()
    {
        $file_path = __DIR__ . '/../display_upute/snimanje_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);
        if(isset($_POST['submit']))
        {
            $nazivSlike = $_POST['naziv_slike'];
            //putanja do slike
            $imagePath = dirname(__FILE__) . '/../view/images/snimanje_upute/' . $nazivSlike;
        
            if(file_exists($imagePath))
            {
                if(unlink($imagePath)) //ovo omogucava brisanje unlink()
                {
                    $brisanje = 'Slika je uspješno uklonjena!';
                    require_once 'view/upute/snimanje_html.php';
                    return;
                }
                else
                {
                    $brisanje = 'Došlo je do greške prilikom brisanja slike!';
                    require_once 'view/upute/snimanje_html.php';
                    return;
                }
            }
            else
            {
                $brisanje = 'Slika tog naslova ne postoji, probajte ponovno (u naslov mora biti uključeno sve)';
                require_once 'view/upute/snimanje_html.php';
                return;
            }
        }
        require_once 'view/upute/snimanje_html.php';
        return;
    }

    public function snimanjedemosi()
    {
        require_once __DIR__ . '/../view/upute-demosi/snimanje-demosi_html.php';
    }

    // Na kraju se ipak ne moze editad opis posla
    public function opisposla()
    {
        $file_path = __DIR__ . '/../display_upute/opisposla_text.php';
        $php_content = $this->libraryService->getFileContent($file_path);

        if (isset($_POST['edited_content'])) {
            $content = $_POST['edited_content'];

            if ($this->libraryService->saveFileContent($file_path, $content)) {
                $php_content = $this->libraryService->getFileContent($file_path);
                require_once 'view/upute/opisposla-admin_html.php';
            } else {
                require_once 'view/upute/opisposla-admin_html.php';
            }
        } else {
            require_once 'view/upute/opisposla-admin_html.php';
        }
    }

    public function opisposlademosi()
    {
        require_once __DIR__ . '/../view/login/opisposla_html.php';
    }
};
