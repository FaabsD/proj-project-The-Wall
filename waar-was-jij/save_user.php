<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php
        $hostname = 'remotemysql.com:3306';
        $username = 'tyMBqP2Y2Y';
        $password = 'z9yRBtqnND';
        $database = 'tyMBqP2Y2Y';
    ?>
    <?php
        try{
            $connection = new PDO('mysql:host='.$hostname.';dbname='.$database, $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Verbinding is gemaakt!";
            // Haal de ingevoerde gegevens uit het formulier via $_POST
            $fullname = $_POST["naam"];
            $gebruikersnaam = $_POST["gebruikersnaam"];
            $email = $_POST["email"];
            $wachtwoord = $_POST["wachtwoord"];
            $veilig_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        } catch(PDOException $e){
            echo 'Fout bij database verbinding: ' . $e->getMessage() . ' op regel '.$e->getLine() . ' in ' . $e->getFile();
        }
    ?>
    <?php 
    // Controlleerd of het e-mailadres niet al aanwezig is in de database
        $checkemail = $connection->prepare("SELECT * FROM users WHERE email=:email");
        $checkemail->execute(["email"=>$email]);
        $gebruiker = $checkemail->fetch();
    ?>
        <?php if ($gebruiker): ?>
            <h1>Er bestaat al een gebruiker onder dit e-mailadres</h1>
        
        <?php else: ?>
            <?php
            $stmt = $connection->prepare(
                "INSERT INTO users (email, full_name, username, password)
                VALUES (:email, :full_name, :username, :password)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':full_name', $fullname);
            $stmt->bindParam(':username', $gebruikersnaam);
            $stmt->bindParam(':password', $veilig_wachtwoord);
            
            $stmt->execute();
            ?>
            <h1>nieuwe gebruiker toegevoegd</h1>
            <a href='index.php'><button>Ga terug naar homepagina</button></a>
            <a href='register.php'><button>Ga terug naar registratie</button></a>
        <?php endif ?>
    
    
</body>
</html>

