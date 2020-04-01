<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Registreren</title>
</head>

<body>
    <nav>
        <h1>Waar was jij?</h1>
        <img src="img/waar_was_jij_logo.png" alt="Logo">
    </nav>
    <aside>
        <img src="img/travel.jpg" alt="">
    </aside>
    <main>
        <header>
            <a href="#"><button>&larr;</button></a>
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