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
            <h1>Waar was jij?</h1>
            <img src="img/waar_was_jij_logo.png" alt="Logo">
        </nav>
        <header>
            <h1><?php echo "Welkom terug" . " " . $_SESSION['username'] ?></h1>
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