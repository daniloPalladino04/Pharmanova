<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Pharmanova</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stile/style.css">
        <link rel="stylesheet" href="stile/style_scelta_login.css">
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
                            echo '<li><a href="d_prenotazioni.php">Prenotazioni</a></li>';
                        }else{
                            echo '<li><a href="prenotazioni.php">Prenotazioni</a></li>';
                        }
                    ?>
                    <li><a href="contatti.php">Contatti</a></li>
                </ul>
            </nav>
        </header>
    
        <main>
            <div id="login">
                <div class = "scelta_login">
                    <p>Accedi a questa sezione se sei un utente e vuoi prenotare un esame o effettuare acquisti</p>
                    <form action="u_login.php">
                        <button class="accedi">
                            <p>accedi come utente</p>
                        </button>
                    </form>
                </div>

                <div class = "scelta_login">
                    <p>Accedi a questa sezione se sei un dipendente e vuoi gestire prenotazioni o prodotti della tua farmacia</p>
                    <form action="d_login.php">
                        <button class="accedi">
                            <p>accedi come dipendente</p>
                        </button>
                    </form>
                </div>
            </div>
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