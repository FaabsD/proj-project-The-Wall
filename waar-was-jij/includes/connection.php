<?php
$hostname = 'remotemysql.com:3306';
$username = 'tyMBqP2Y2Y';
$password = 'z9yRBtqnND';
$database = 'tyMBqP2Y2Y';
?>
    <?php
    try {
        $connection = new PDO('mysql:host=' . $hostname . ';dbname=' . $database, $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Verbinding is gemaakt!";
    } catch (PDOException $e) {
        echo 'Fout bij database verbinding: ' . $e->getMessage() . ' op regel ' . $e->getLine() . ' in ' . $e->getFile();
    }
    ?>