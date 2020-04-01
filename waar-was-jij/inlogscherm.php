<!-- ik heb de variabele enzo in het engels gedaan en boven de code gezet waarvoor het is.
 Ik heb sommige dingen van het internet omdat ik er echt zelf niet uitkwam. 
 Kijk zelf ook nog maar naar de code of je dingen kan veranderen/verwijderen. -->

<?php
// start de sessie
session_start();

// Checked of de gebruiker al ingelogd is, zo ja gaat ie naar welkompagina
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: gebruikers-pagina.php");
    exit;
}

// config file erbij
require_once "config.php";

// De variabele die empty zijn
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted (makkelijker in engels uit te leggen)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check of username leeg is
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check of wachtwoord leeg is
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validatie voor gebruikersnaam en wachtwoord
    if (empty($username_err) && empty($password_err)) {
        // bereid een select statement voor
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?"; //id veranderd naar user_id

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variabelen aan de voorbereidde statement van parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Zet parameters
            $param_username = $username;

            // probeer de statement uit te voeren
            if (mysqli_stmt_execute($stmt)) {
                // Store resultaat
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password); // hier ook $id veranderd naar $user_id 
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id; // verandering id naar user_id en $id naar $user_id
                            $_SESSION["username"] = $username;

                            // Redirect gebruiker naar welkom pagina
                            header("location: gebruikers-pagina.php");
                        } else {
                            // error message als wachtwoord niet klopt
                            $password_err = "Dit wachtwoord klopt niet.";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "Geen account gevonden met die gebruikersnaam.";
                }
            } else {
                echo "Oeps! Er ging iets fout. Probeer het later nog een keer.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<!-- ik heb je html hergestructureerd -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inlogscherm.css">
    <title>Waar was jij?</title>
</head>

<body>
    <nav>
        <h1>Waar was jij?</h1>
        <img src="img/waar_was_jij_logo.png" alt="Logo">
    </nav>
    <aside>
        <img src="Foto_inlogscherm.jpg" alt="Foto_inlogscherm">
    </aside>
    <main>
        <header>
            <h2>log in</h2>
        </header>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" placeholder="Password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </main>

</body>

</html>