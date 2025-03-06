<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_users = "login";
$db_prenotazioni = "prenotazioni";
$db_shop = "shop";


// Connessione al database degli utenti
$conn_users = new mysqli($host, $user, $pass, $db_users);
if ($conn_users->connect_error) {
    echo "Failed to connect to users DB: " . $conn_users->connect_error;
}

// Connessione al database delle prenotazioni
$conn_prenotazioni = new mysqli($host, $user, $pass, $db_prenotazioni);
if ($conn_prenotazioni->connect_error) {
    echo "Failed to connect to prenotazioni DB: " . $conn_prenotazioni->connect_error;
}

$conn_shop = new mysqli($host, $user, $pass, $db_shop);
if ($conn_shop->connect_error) {
    echo "Failed to connect to shop DB: " . $conn_shop->connect_error;
}
?>