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
                    <li><a href="index.php" class="active">Home</a></li>
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
            <div class="container" id="signup" style="display:none;">
                <h1 class="form-title">Registrati</h1>
                <form method="post" action="u_registrazione.php">
                    <div class="input-group">
                        <label for="fname">Nome:</label>
                        <input type="text" name="fName" id="fName" required>
                    </div>
                    <div class="input-group">
                        <label for="lName">Cognome:</label>
                        <input type="text" name="lName" id="lName" required>
                        
                    </div>
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn" value="Sign Up" name="signUp">Registrati</button>
                </form>
                <?php if(isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
                    <script>
                        document.getElementById('signup').style.display = 'block';
                    </script>
                    <p style="color: red;">Indirizzo email già esistente</p>
                <?php endif; ?>
                <div class="links">
                    <p class="change">Hai già un Account?</p>
                    <button id="signInButton">Accedi</button>
                </div>
            </div>

            <div class="container" id="signIn">
                <?php if(isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
                    <script>
                        document.getElementById('signIn').style.display = 'none';
                    </script>
                <?php endif; ?>
                <h1 class="form-title">Accedi</h1>
                <form method="post" action="u_registrazione.php">
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn" value="Sign In" name="signIn">Accedi</button>
                </form>
                <?php if(isset($_GET['error']) && $_GET['error'] == 'login_failed'): ?>
                    <p style="color: red;">Username o password errati</p>
                <?php endif; ?>
                <div class="links">
                    <p class = "change">Non hai ancora un Account?</p>
                    <button id="signUpButton">Registrati</button>
                </div>
            </div>
            <script src="script/script.js"></script>
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