<?php 
    session_start();
    require 'includes/connection.php';
    // haal id op uit link
    $id = $_GET['id'];
    // zet de user_id in variabele
    $user_id = $_SESSION['user_id'];

    // verwijder de foto/post
    $to_delete = $connection->prepare("DELETE FROM user_images WHERE id = $id AND user_id = $user_id");
    $to_delete->execute();
    $deleted = $to_delete->rowCount();

    // Stuur gebruiker terug naar zijn/haar pagina
    header('Location: gebruikers-pagina.php');

?>