<?php session_start(); ?>

<?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/upload.css">
        <link rel="stylesheet" href="css/menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Foto Uploaden</title>
    </head>

    <body>
        <nav>
            <input type="checkbox" id="menuSwitcher" checked>
            <div class="menu">
                <label class="close-menu" for="menuSwitcher"><i class="fa fa-bars"></i></label>
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a class="active" href="foto-upload.php">Uploaden</a>
                    </li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
                        <li>
                            <a href="gebruikers-pagina.php">Mijn pagina</a>
                        </li>
                    <?php endif ?>
                    <li>
                        <a href="register.php">Registreren</a>
                    </li>
                    <li>
                        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
                            <a href="logout.php">Uitloggen</a>
                        <?php else : ?>
                            <a href="inlogscherm.php">Inloggen</a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
            <label for="menuSwitcher" class="haal-menu"><i class="fa fa-bars"></i></label>
            <h1>Waar was jij?</h1>
            <img src="img/waar_was_jij_logo.png" alt="Logo">
        </nav>
        <aside>
            <img src="img/holiday.jpg" alt="wayfarer zonnebril op strandzand overdag">
        </aside>
        <main>
            <header>
                <a href="home.php"><button>&larr;</button></a>
                <h2>Nieuwe foto plaatsen</h2>
            </header>
            <form action="foto-upload.php" method="post" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Titel" required>
                <textarea name="description" cols="30" rows="10" maxlength="280" placeholder="Beschrijving max: 280 tekens"></textarea>
                <br>
                <label for="picture">Foto om te uploaden:<br></label>
                <input type="file" name="picture" required accept="image/jpeg, image/png">
                <!-- Voer het uploaden uit als er een post request wordt verzonden -->
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Sla alle fouten die er zijn op in een array
                    $errors = [];
                    //check of er een afbeelding is geupload
                    if (!isset($_FILES['picture'])) {
                        echo 'Geen bestand Geupload!';
                        exit;
                    } else {
                        // check bestand op errors
                        $file_error = $_FILES['picture']['error'];
                        switch ($file_error) {
                            case UPLOAD_ERR_OK:
                                break;
                            case UPLOAD_ERR_NO_FILE:
                                $errors[] = 'Er is geen bestand geupload';
                                break;
                            case UPLOAD_ERR_CANT_WRITE:
                                $errors[] = 'Kan niet schrijven naar disk';
                                break;
                            case UPLOAD_ERR_INI_SIZE:
                            case UPLOAD_ERR_FORM_SIZE:
                                $errors[] = 'Dit bestand is te groot, pas php.ini aan';
                                break;
                            default:
                                $errors[] = 'Onbekende fout';
                        }
                    }
                    // ga verder mits er geen fouten zij
                    if (count($errors) === 0) {
                        // Bestandsnaam in key: name
                        $file_name = $_FILES['picture']['name'];

                        // Grootte in bytes in key: size
                        $file_size = $_FILES['picture']['size'];

                        // Tijdelijke opslag in key: tmp_name
                        $file_tmp = $_FILES['picture']['tmp_name'];

                        // Bestandstype in key: type
                        $file_type = $_FILES['picture']['type'];


                        // Bestands types die geaccepteerd moeten worden
                        $valid_image_types = [
                            1 => 'gif',
                            2 => 'jpg',
                            3 => 'png'
                        ];
                        $image_type        = exif_imagetype($file_tmp);
                        if ($image_type !== false) {
                            // Juiste bestandsextensie zoeken
                            $file_extension = $valid_image_types[$image_type];
                        } else {
                            $errors[] = 'Dit is geen afbeelding!';
                        }
                    }

                    // doorgaan om bestand een unieke naam te geven mits er geen fouten zijn, anders
                    if (count($errors) === 0) {
                        // Willekeurige bestandsnaam genereren
                        $new_filename = sha1_file($file_tmp) . '.' . $file_extension;
                        $final_filename = 'uploads/' . $new_filename;

                        // met move_uploaded_file verplaats je het tijdelijke bestand naar de uiteindelijke plek
                        move_uploaded_file($file_tmp, $final_filename); // dus van tijdelijke bestandsnaam naar de originele naam (in de huidige map);

                        // Op deze plek sla je de bestandsnaam en andere gegevens op in je database, dat mag je zelf doen.

                        include 'includes/connection.php';

                        // Kopieer de gegevens uit $_POST naar eigen variabelen
                        $title = $_POST["title"];
                        $description = $_POST["description"];
                        $picture = $new_filename;
                        $user_id = $_SESSION['user_id'];

                        // Bereid de SQL voor en bind de variabelen aan de juiste :placeholder parameters
                        $stmt = $connection->prepare(
                            "INSERT INTO user_images (Titel, Beschrijving, afbeelding, user_id) 
                                VALUES (:Titel, :Beschrijving, :afbeelding, :user_id)"
                        );
                        $stmt->bindParam(':Titel', $title);
                        $stmt->bindParam(':Beschrijving', $description);
                        $stmt->bindParam(':afbeelding', $picture);
                        $stmt->bindParam(':user_id', $user_id);

                        // Voor het SQL statement uit
                        $stmt->execute();
                        //stuur door naar startpagina
                        header('location: home.php');
                    }
                }
                ?>
                <br>
                <input type="submit" value="Uploaden">
            </form>
        </main>
    </body>

    </html>
<?php else : ?>
    <?php header("location: inlogscherm.php"); ?>
<?php endif ?>