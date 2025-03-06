<?php
    session_start();
    include("u_connect.php");
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
                if(isset($_SESSION['email'])){
                    $email=$_SESSION['email'];
                    $query=mysqli_query($conn_users, "SELECT users.* FROM `users` WHERE users.email='$email'");
                    while($row=mysqli_fetch_array($query)){
                        echo '<p> Salve '.$row['firstName'].'</p>';
                    }
                }
                ?>
            
            <form action="index.php">
                <button type="submit" class="btn">Continua</button>
            </form>
        </div>
    </main>
    
</body>
</html>