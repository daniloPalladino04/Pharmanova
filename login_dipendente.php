<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Pharmanova</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stile/style.css">
        <link rel="stylesheet" href="stile/style_login.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />        
    </head>

    <body>

        <header>
            <div id = "head">

                <div id="orari">
                    <p>Orari di apertura:</p>
                    <p>Lun-Ven 8:30 - 19:30</p>
                    <p>Sab 8:30 - 12:30</p>
                    <?php
                        date_default_timezone_set('Europe/Rome');
                        $currentDay = date('N');
                        $currentTime = date('H:i');

                        $isOpen = false;

                        if ($currentDay >= 1 && $currentDay <= 5) {
                            if ($currentTime >= '08:30' && $currentTime <= '19:30') {
                                $isOpen = true;
                            }
                        } elseif ($currentDay == 6) {
                            if ($currentTime >= '08:30' && $currentTime <= '12:30') {
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

                <div id = "logo">
                    <img src="immagini/PharmaNova_logo1.png" alt="logo" id="logo_img">
                    <div id = "testo_logo">
                        <h1>PHARMANOVA</h1>
                        <h2>dal 1824</h2>
                    </div>
                    
                </div>

                <div class="header-links">
                    <form action="cart.php">
                        <button id="link_shopping_cart">
                            <span class="material-symbols-outlined">shopping_cart</span>
                        </button>
                    </form>
                    <form action="scelta_login.php">
                        <button id="link_area_riservata">
                            <span class="material-symbols-outlined">account_circle</span>
                        </button>
                    </form>
                </div>
            </div>

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="servizi.php">Servizi</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="prenotazioni.php">Prenotazioni</a></li>
                    <li><a href="contatti.php">Contatti</a></li>
                </ul>
            </nav>
        </header>
    
        <main>
            <div id="login">
                <h1>Area riservata dipendente</h1>
                <form action="login_dipendente.php" method="post">
                    <label for="email">Username:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Accedi</button>
                </form>
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
                        <li><a href="shop.php">Shop</a></li>
                        <li><a href="prenotazioni.php">Prenotazioni</a></li>
                        <li><a href="contatti.php">Contatti</a></li>
                    </ul>
                </div>
                <div class="footer-section contact">
                    <h2>Contatti</h2>
                    <section id = "indirizzo">
                        <span class="material-symbols-outlined">location_on</span>
                        <p>Via Roma, 123, 00100 Roma RM</p>
                    </section>

                    <section id = "telefono">
                        <span class="material-symbols-outlined">phone</span>
                        <p>+39 06 12345678</p>
                    </section>
                    
                    <section id = "mail">
                        <span class="material-symbols-outlined">email</span>
                        <p>info@pharmanova.it</p>
                    </section>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2023 Pharmanova | Tutti i diritti riservati
            </div>
        </footer>

    </body>
</html>