<?php
/*$hostname = 'remotemysql.com:3306';
    $username = 'tyMBqP2Y2Y';
    $password = 'z9yRBtqnND';
    $database = 'tyMBqP2Y2Y';

    try {
        $connection = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Verbinding is gemaakt!";
    } catch (PDOException $e) {
        echo 'Fout bij database verbinding: ' . $e->getMessage() . ' op regel ' . $e->getLine() . ' in ' . $e->getFile();
    }*/
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'remotemysql.com:3306');
define('DB_USERNAME', 'tyMBqP2Y2Y');
define('DB_PASSWORD', 'z9yRBtqnND');
define('DB_NAME', 'tyMBqP2Y2Y');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
