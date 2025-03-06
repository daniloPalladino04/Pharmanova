<?php
    session_start();
    include("d_connect.php");
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <title>Login Riuscito</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile/style.css">
    <link rel="stylesheet" href="stile/style_login_success.css">
</head>
<body>
    
    <main>
        <div class="container">
            <h1>Accesso Effettuato</h1>
            <?php 
                if(isset($_SESSION['username'])){
                    $username=$_SESSION['username'];
                    $query=mysqli_query($conn, "SELECT employees.* FROM `employees` WHERE employees.username='$username'");
                    while($row=mysqli_fetch_array($query)){
                        echo '<p> Bentornato/a '.$row['firstName'].'</p>';
                    }
                }
                ?>
            
            <form action="index.php">
                <button type="submit" class="btn">Home</button>
            </form>
            <form action="d_prenotazioni.php">
                <button type="submit" class="btn">Gestisci Prenotazioni</button>
            </form>
            <form action="inserimento_p.php">
                <button type="submit" class="btn">Gestisci Prodotti</button>
            </form>
        </div>
    </main>
    
</body>
</html>