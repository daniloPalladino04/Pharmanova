<?php
session_start();
include 'u_connect.php';

if (!isset($_SESSION['email'])) {
    header("Location: scelta_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])) {
        $prenotazione_id = $_POST['prenotazione_id'];
        $deleteQuery = "DELETE FROM prenotazioni WHERE id='$prenotazione_id' AND user_id='$user_id'";
        if ($conn_prenotazioni->query($deleteQuery) === TRUE) {
            $success = "Prenotazione eliminata con successo.";
        } else {
            $error = "Errore durante l'eliminazione della prenotazione: " . $conn_prenotazioni->error;
        }
    } else {
        $tipo_esame = $_POST['tipo_esame'];
        $data = $_POST['data'];
        $orario = $_POST['orario'];

        // Controlla se l'utente ha già effettuato 3 prenotazioni nella data selezionata
        $checkLimitQuery = "SELECT COUNT(*) as count FROM prenotazioni WHERE user_id='$user_id' AND data='$data'";
        $checkLimitResult = $conn_prenotazioni->query($checkLimitQuery);
        $limitRow = $checkLimitResult->fetch_assoc();

        if ($limitRow['count'] >= 3) {
            $error = "Hai già effettuato 3 prenotazioni per la data selezionata.";
        } else {
            // Controlla se l'utente ha già una prenotazione per quel tipo di esame nella data selezionata
            $checkQuery = "SELECT * FROM prenotazioni WHERE user_id='$user_id' AND tipo_esame='$tipo_esame' AND data='$data'";
            $checkResult = $conn_prenotazioni->query($checkQuery);

            if ($checkResult->num_rows > 0) {
                $error = "Hai già una prenotazione per questo tipo di esame nella data selezionata.";
            } else {
                // Controlla se l'orario è già prenotato
                $checkOrarioQuery = "SELECT * FROM prenotazioni WHERE data='$data' AND orario='$orario'";
                $checkOrarioResult = $conn_prenotazioni->query($checkOrarioQuery);

                if ($checkOrarioResult->num_rows > 0) {
                    $error = "L'orario selezionato è già prenotato.";
                } else {
                    $insertQuery = "INSERT INTO prenotazioni (user_id, tipo_esame, data, orario) VALUES ('$user_id', '$tipo_esame', '$data', '$orario')";
                    if ($conn_prenotazioni->query($insertQuery) === TRUE) {
                        $success = "Prenotazione effettuata con successo.";
                    } else {
                        $error = "Errore durante la prenotazione: " . $conn_prenotazioni->error;
                    }
                }
            }
        }
    }
}

// Recupera lo storico delle prenotazioni dell'utente
$prenotazioniQuery = "SELECT * FROM prenotazioni WHERE user_id='$user_id' ORDER BY data DESC, orario DESC";
$prenotazioniResult = $conn_prenotazioni->query($prenotazioniQuery);

// Recupera gli orari già prenotati per la data selezionata
$orariPrenotati = [];
if (isset($_POST['data'])) {
    $dataSelezionata = $_POST['data'];
    $orariQuery = "SELECT orario FROM prenotazioni WHERE data='$dataSelezionata'";
    $orariResult = $conn_prenotazioni->query($orariQuery);
    while ($row = $orariResult->fetch_assoc()) {
        $orariPrenotati[] = $row['orario'];
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Prenotazioni - Pharmanova</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile/style.css">
    <link rel="stylesheet" href="stile/style_prenotazioni.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />        
</head>
<body>
        <header>
            <div id="head">

                <div id="orari">
                    <p id="interlinea_s">Orari di apertura:</p>
                    <p id="interlinea_g">Lun-Sab:  8:30 - 19:30</p>
                    <?php
                        date_default_timezone_set('Europe/Rome');
                        $currentDay = date('N');
                        $currentTime = date('H:i');

                        $isOpen = false;

                        if ($currentDay >= 1 && $currentDay <= 6) {
                            if ($currentTime >= '08:30' && $currentTime <= '19:30') {
                                $isOpen = true;
                            }
                        }

                        if ($isOpen) {
                            echo '<p style="color: green;">Aperti ora</p>';
                        } else {
                            echo '<p style="color: red;">Chiusi ora</p>';
                        }
                    ?>
                </div>

                <div id="logo">
                    <a href="index.php"><img src="immagini/PharmaNova_logo1.png" alt="logo" id="logo_img"></a>
                    <div id="testo_logo">
                        <h1>PHARMANOVA</h1>
                        <h2>dal 1824</h2>
                    </div>
                    
                </div>

                <div class="header-links">
                    <?php
                        if (!isset($_SESSION['username'])) {
                            echo '<form action="cart.php">
                                    <button id="link_shopping_cart">
                                        <span class="material-symbols-outlined">shopping_cart</span>
                                    </button>
                                </form>';
                        }
                    ?>
                    <div id="account-button-container">
                        <!-- Questo contenuto verrà aggiornato tramite JavaScript -->
                    </div>
                </div>
            </div>

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="servizi.php">Servizi</a></li>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<li><a href="inserimento_p.php">Shop</a></li>';
                        }elseif (isset($_SESSION['firstName'])) {
                            echo '<li><a href="shop.php">Shop</a></li>';
                        }else{
                            echo '<li><a href="scelta_login.php">Shop</a></li>';
                        }
                    ?>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<li><a href="d_prenotazioni.php">Prenotazioni</a></li>';
                        }else{
                            echo '<li><a href="prenotazioni.php"  class = "active">Prenotazioni</a></li>';
                        }
                    ?>
                    <li><a href="contatti.php">Contatti</a></li>
                </ul>
            </nav>
        </header>
    
    <main>
        <h1>Prenotazioni</h1>
        

        <form method="post" action="prenotazioni.php" class="form-container">
            <h2 id = "effettua" >Effettua una Prenotazione</h2>
            <div class="input-group">
                <label for="tipo_esame">Tipo di esame:</label>
                <select name="tipo_esame" id="tipo_esame" required>
                    <option value="">Seleziona un tipo di esame</option>
                    <option value="ECG">ECG</option>
                    <option value="Analisi del sangue">Analisi del sangue</option>
                    <option value="Esami delle urine">Esami delle urine</option>
                </select>
            </div>
            <div class="input-group">
                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="input-group">
                <label for="orario">Orario:</label>
                <select name="orario" id="orario" required>
                    <?php
                    $start = new DateTime('08:30');
                    $end = new DateTime('19:30');
                    $interval = new DateInterval('PT30M');
                    $times = new DatePeriod($start, $interval, $end);

                    foreach ($times as $time) {
                        $formattedTime = $time->format('H:i');
                        if (!in_array($formattedTime, $orariPrenotati)) {
                            echo '<option value="' . $formattedTime . '">' . $formattedTime . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn">Prenota</button>
        </form>

        <h2 id="storico">Storico Prenotazioni</h2>
        <?php if (isset($error)): ?>
            <p class = "stato" style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class = "stato" style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Tipo di esame</th>
                    <th>Data</th>
                    <th>Orario</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $prenotazioniResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['tipo_esame']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['data'])); ?></td>
                        <td><?php echo date('H:i', strtotime($row['orario'])); ?></td>
                        <?php
                        if ($row['stato'] == 'accettata') {
                            echo '<td style="color:green">' . $row['stato'] . '</td>'; 
                        } elseif ($row['stato'] == 'rifiutata') {
                            echo '<td style="color:red">' . $row['stato'] . '</td>';
                        } else {
                            echo '<td>' . $row['stato'] . '</td>';
                        }
                        ?>
                        <td>
                            <form method="post" action="prenotazioni.php" onsubmit="return confirm('Sei sicuro di voler eliminare questa prenotazione?');">
                                <input type="hidden" name="prenotazione_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete" class="btn">Elimina</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
 
    <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h2>Pharmanova</h2>
                <p>Pharmanova è una farmacia storica che offre una vasta gamma di servizi e prodotti per la salute e il benessere. Dal 1824, ci impegniamo a fornire il miglior servizio ai nostri clienti.</p>
            </div>
            <div class="footer-section links">
                <h2>Link Utili</h2>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="servizi.php">Servizi</a></li>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<li><a href="inserimento_p.php">Shop</a></li>';
                        }elseif (isset($_SESSION['firstName'])) {
                            echo '<li><a href="shop.php">Shop</a></li>';
                        }else{
                            echo '<li><a href="scelta_login.php">Shop</a></li>';
                        }
                    ?>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<li><a href="d_prenotazioni.php">Prenotazioni</a></li>';
                        }else{
                            echo '<li><a href="prenotazioni.php">Prenotazioni</a></li>';
                        }
                    ?>
                    <li><a href="contatti.php">Contatti</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Contatti</h2>
                <address>
                    <section id="indirizzo">
                        <span class="material-symbols-outlined">location_on</span>
                        <p>Via Roma, 123, 00100 Roma RM</p>
                    </section>
                    <section id="telefono">
                        <span class="material-symbols-outlined">phone</span>
                        <p>+39 06 12345678</p>
                    </section>
                    <section id="mail">
                        <span class="material-symbols-outlined">email</span>
                        <p>info@pharmanova.it</p>
                    </section>
                </address>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2024 Pharmanova | Tutti i diritti riservati
        </div>
    </footer>
    <script>
        const isLoggedIn = <?php echo isset($_SESSION['firstName']) ? 'true' : 'false'; ?>;
        const initialFn = '<?php echo isset($_SESSION['firstName']) ? strtoupper($_SESSION['firstName'][0]) : ''; ?>';
        const initialLn = '<?php echo isset($_SESSION['lastName']) ? strtoupper($_SESSION['lastName'][0]) : ''; ?>';
    </script>
    <script src="script/script.js"></script>
</body>
</html>