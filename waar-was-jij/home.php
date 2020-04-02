<?php
session_start();
require 'includes/connection.php';
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Waar was jij? Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Bram van Baren, Fabian Hendriks">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <?php
    $all_posts = "SELECT * 
    FROM user_images
    INNER JOIN users
    ON users.user_id = user_images.user_id";
    $statement = $connection->query($all_posts);
    ?>
    <nav>
        <input type="checkbox" id="menuSwitcher" checked>
        <div class="menu">
            <label class="close-menu" for="menuSwitcher"><i class="fa fa-bars"></i></label>
            <ul>
                <li>
                    <a class="active" href="home.php">Home</a>
                </li>
                <li>
                    <a href="foto-upload.php">Uploaden</a>
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
    <main>
        <?php foreach ($statement as $post) : ?>
            <section>
                <p><?php echo $post['username'] ?></p>
                <div class="thumb">
                    <img src="uploads/<?php echo $post['afbeelding'] ?>" alt="">
                </div>
                <div class="informatie">
                    <img src="uploads/<?php echo $post['afbeelding'] ?>" alt="">
                    <h3><?php echo $post['Titel'] ?></h3>
                    <p>
                        <?php echo $post['Beschrijving'] ?>
                    </p>
                </div>
            </section>
        <?php endforeach ?>


    </main>
    <script src="javascript.js"></script>
</body>

</html>