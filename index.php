<?php
session_start();
include 'u_connect.php'; // Assicurati che questo file contenga la connessione al database

// Recupera alcuni prodotti dal database
$productsQuery = "SELECT * FROM products LIMIT 3";
$productsResult = $conn_shop->query($productsQuery);
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Pharmanova</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stile/style.css">
        <link rel="stylesheet" href="stile/style_index.css">
        <link rel="stylesheet" href="stile/style_shop.css">
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
            <section class="hero">
                <div class="hero-content">
                    <h1>Benvenuti su Pharmanova</h1>
                    <p>La tua farmacia di fiducia dal 1824</p>
                    <form action="shop.php" method="get">
                        <button type="submit" class="btn">Scopri i nostri prodotti</button>
                    </form>
                </div>
            </section>
            <section class="news">
                <h2>Ultime Notizie</h2>
                <div class="news-container">
                    <div class="news-item">
                        <div class="news-content">
                            <img src="immagini/telemedicina.jpg" alt="telemedicina">
                            <h3>Nuovo Servizio di Telemedicina</h3>
                            <p>Pharmanova lancia un nuovo servizio di telemedicina per consulti a distanza.</p>
                            <button class="btn flip-btn">Vedi l'articolo completo</button>
                        </div>
                        <div class="news-back">
                            <h3>Nuovo Servizio di Telemedicina</h3>
                            <p>Il nuovo servizio di telemedicina permette ai pazienti di consultarsi con i medici a distanza, utilizzando la tecnologia per fornire assistenza sanitaria di alta qualità. Questo servizio è disponibile per tutti i nostri clienti e offre la possibilità di ricevere diagnosi e consigli medici senza dover lasciare la propria casa. La telemedicina è particolarmente utile per i pazienti con mobilità ridotta o per coloro che vivono in aree remote.</p>
                            <button class="btn flip-btn">Torna indietro</button>
                        </div>
                    </div>
                    <div class="news-item">
                        <div class="news-content">
                            <img src="immagini/vaccinazione.jpeg" alt="vaccinazione">
                            <h3>Vaccinazione Antinfluenzale</h3>
                            <p>Inizia la campagna di vaccinazione antinfluenzale presso la nostra farmacia.</p>
                            <button class="btn flip-btn">Vedi l'articolo completo</button>
                        </div>
                        <div class="news-back">
                            <h3>Vaccinazione Antinfluenzale</h3>
                            <p>La nostra campagna di vaccinazione antinfluenzale è iniziata. Vieni a trovarci per proteggerti dall'influenza stagionale. Offriamo vaccini sicuri ed efficaci, somministrati da personale sanitario qualificato. La vaccinazione è particolarmente importante per le persone con condizioni di salute preesistenti, come il diabete o le malattie cardiache, che sono a maggior rischio di complicazioni influenzali.</p>
                            <button class="btn flip-btn">Torna indietro</button>
                        </div>
                    </div>
                    <div class="news-item">
                        <div class="news-content">
                            <img src="immagini/orari.jpg" alt="orari">
                            <h3>aggiornamento Orari di Apertura</h3>
                            <p>Pharmanova estende gli orari di apertura per meglio servire i propri clienti.</p>
                            <button class="btn flip-btn">Vedi l'articolo completo</button>
                        </div>
                        <div class="news-back">
                            <h3>Nuovi Orari di Apertura</h3>
                            <p>Abbiamo esteso i nostri orari di apertura per offrirti un servizio ancora migliore. Siamo ora aperti dalle 8:30 alle 19:30 dal lunedì al sabato. Questo cambiamento è stato fatto per garantire che tu possa accedere ai nostri servizi quando ne hai più bisogno. Che tu abbia bisogno di farmaci, consigli medici o altri prodotti per la salute, siamo qui per aiutarti nei nuovi orari estesi.</p>
                            <button class="btn flip-btn">Torna indietro</button>
                        </div>
                    </div>
                </div>
            </section>
            <section class="shop-preview">
                <h2>Prodotti in evidenza</h2>
                <div class="shop-container">
                    <?php while ($product = $productsResult->fetch_assoc()): ?>
                        <div class="product">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <h3><?php echo $product['name']; ?></h3>
                            <p><?php echo $product['description']; ?></p>
                            <p class="price">€<?php echo number_format($product['price'], 2); ?></p>
                            <?php
                                if (isset($_SESSION['firstName'])) {
                                    echo '<form method="post" action="shop.php">';
                                    echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                                }else{
                                    echo '<form action="scelta_login.php">';
                                }
                            ?>
                            <?php
                                if (!isset($_SESSION['username'])) {
                                    echo '<button type="submit" name="add_to_cart" class="btn">Aggiungi al carrello</button>';
                                }
                            ?>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="shop-all">
                    <form action="shop.php" method="get">
                        <button type="submit" class="btn">Visualizza tutti i prodotti</button>
                    </form>
                </div>
            </section>
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
                        <li><a href="index.php" >Home</a></li>
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

            document.querySelectorAll('.flip-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const newsItem = button.closest('.news-item');
                    newsItem.classList.toggle('flipped');
                });
            });
        </script>
        <script src="script/script.js"></script>
    </body>
    
</html>