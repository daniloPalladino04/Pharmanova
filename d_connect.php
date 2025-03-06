<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "login_d";
$db_prenotazioni = "prenotazioni";

// Connessione al database degli utenti
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo "Failed to connect DB: " . $conn->connect_error;
}

// Connessione al database delle prenotazioni
$conn_prenotazioni = new mysqli($host, $user, $pass, $db_prenotazioni);
if ($conn_prenotazioni->connect_error) {
    echo "Failed to connect to prenotazioni DB: " . $conn_prenotazioni->connect_error;
}
?>