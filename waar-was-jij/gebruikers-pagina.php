<?php
//start sessie 
session_start();
?>

<!-- Als er een gebruiker is ingelogd wordt er verbinding gemaakt met de database -->
<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
    <?php include 'includes/connection.php'; ?>
    <!DOCTYPE html>
    <html lang="">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/users.css">
        <link rel="stylesheet" href="css/menu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Als een kleine toevoeging wordt de titel Waar was "gebruikersnaam"?-->
        <title> Waar was <?php echo $_SESSION['username'] ?>?</title>
    </head>

    <body>
        <?php
        //haal de foto's van de ingelogde gebruiker op
        $user_id = $_SESSION['user_id'];
        $user_posts = "SELECT * FROM user_images WHERE user_id = '$user_id'";
        $statement = $connection->query($user_posts);

        ?>
        <nav>
            <input type="checkbox" id="menuSwitcher" checked>
            <div class="menu">
                <label class="close-menu" for="menuSwitcher"><i class="fa fa-bars"></i></label>
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="foto-upload.php">Uploaden</a>
                    </li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
                        <li>
                            <a class="active" href="gebruikers-pagina.php">Mijn pagina</a>
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
        <header>
            <h2><?php echo "Welkom terug" . " " . $_SESSION['username'] ?></h2>
        </header>
        <main>
            <!-- Maak voor iedere post met het corresponderende user id een section in het main element -->
            <?php foreach ($statement as $posts) : ?>
                <section>
                    <h2><?php echo $posts['Titel'] ?></h2>
                    <img src="uploads/<?php echo $posts['afbeelding'] ?>" alt="">
                    <p><?php echo $posts['Beschrijving'] ?></p>
                    <a href="verwijder-foto.php?id=<?php echo $posts['id'] ?>">
                        <button class="delete-button">Verwijder afbeelding</button>
                    </a>
                </section>
            <?php endforeach ?>
        </main>

    </body>

    </html>


<?php else : ?>
    <?php header('location: inlogscherm.php'); ?>
<?php endif ?>