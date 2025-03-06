<?php
include 'u_connect.php'; // Assicurati che questo file contenga la connessione al database

if (isset($_POST['upload'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    // Directory di destinazione per le immagini
    $target_dir = "prodotti/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Controlla se il file è un'immagine reale
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        die("Il file non è un'immagine.");
    }

    // Controlla se il file esiste già
    if (file_exists($target_file)) {
        die("Il file esiste già.");
    }

    // Controlla la dimensione del file
    if ($image["size"] > 5000000) { // 5MB
        die("Il file è troppo grande.");
    }

    // Consenti solo alcuni formati di file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        die("Sono consentiti solo i formati JPG, JPEG, PNG e GIF.");
    }

    // Prova a caricare il file
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        // Inserisci i dettagli del prodotto nel database
        $insertQuery = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$target_file')";
        if ($conn_shop->query($insertQuery) === TRUE) {
            echo "Il prodotto è stato caricato con successo.";
        } else {
            echo "Errore: " . $conn_shop->error;
        }
    } else {
        echo "Si è verificato un errore durante il caricamento del file.";
    }
}
?>