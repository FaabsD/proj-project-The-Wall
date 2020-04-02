<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Registreren</title>
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
                    <a href="foto-upload.php">Uploaden</a>
                </li>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) : ?>
                    <li>
                        <a href="gebruikers-pagina.php">Mijn pagina</a>
                    </li>
                <?php endif ?>
                <li>
                    <a class="active" href="register.php">Registreren</a>
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
        <img src="img/travel.jpg" alt="">
    </aside>
    <main>
        <header>
            <a href="home.php"><button>&larr;</button></a>
            <h2>Registreren</h2>
        </header>
        <form action="save_user.php" method="post">
            <input type="email" name="email" placeholder="E-mail adres">
            <input type="text" name="naam" placeholder="Volledige naam">
            <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam">
            <input type="password" name="wachtwoord" placeholder="Wachtwoord">
            <input type="submit" value="Maak account aan">
        </form>
    </main>

</body>

</html>