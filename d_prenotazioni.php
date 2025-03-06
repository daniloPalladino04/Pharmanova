<?php
session_start();
include 'd_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: d_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $prenotazione_id = $_POST['prenotazione_id'];
    $action = $_POST['action'];

    if ($action == 'accetta') {
        $updateQuery = "UPDATE prenotazioni SET stato='accettata' WHERE id='$prenotazione_id'";
    } elseif ($action == 'rifiuta') {
        $updateQuery = "UPDATE prenotazioni SET stato='rifiutata' WHERE id='$prenotazione_id'";
    }

    if ($conn_prenotazioni->query($updateQuery) === TRUE) {
        $success = "Prenotazione aggiornata con successo.";
    } else {
        $error = "Errore durante l'aggiornamento della prenotazione: " . $conn_prenotazioni->error;
    }
}

// Recupera tutte le prenotazioni
$prenotazioniQuery = "SELECT prenotazioni.*, users.firstName, users.lastName, users.email FROM prenotazioni JOIN login.users ON prenotazioni.user_id = users.Id ORDER BY data DESC, orario DESC";
$prenotazioniResult = $conn_prenotazioni->query($prenotazioniQuery);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Gestione Prenotazioni - Pharmanova</title>
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
                        }else{
                            echo '<li><a href="shop.php">Shop</a></li>';
                        }
                    ?>
                    <?php
                        if (isset($_SESSION['username'])) {
                            echo '<li><a href="d_prenotazioni.php" class="active">Prenotazioni</a></li>';
                        }else{
                            echo '<li><a href="prenotazioni.php">Prenotazioni</a></li>';
                        }
                    ?>
                    <li><a href="contatti.php">Contatti</a></li>
                </ul>
            </nav>
        </header>
    
    <main>
        <h1>Gestione Prenotazioni</h1>

        <h2>Tutte le Prenotazioni</h2>
        <table>
            <thead>
                <tr>
                    <th>Tipo di esame</th>
                    <th>Data</th>
                    <th>Orario</th>
                    <th>Stato</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Email</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $prenotazioniResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['tipo_esame']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['data'])); ?></td>
                        <td><?php echo date('H:i', strtotime($row['orario'])); ?></td>
                        <td><?php echo $row['stato']; ?></td>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <form method="post" action="d_prenotazioni.php">
                                <input type="hidden" name="prenotazione_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="accetta" class="btn">Accetta</button>
                                <button type="submit" name="action" value="rifiuta" class="btn">Rifiuta</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php endif; ?>
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
                    <li><a href="index.php" class="active">Home</a></li>
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