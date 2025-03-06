<?php 
include 'u_connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $checkEmail="SELECT * FROM users WHERE email='$email'";
    $result=$conn_users->query($checkEmail);
    if($result->num_rows>0){
        header("Location: u_login.php?error=email_exists");
        exit();
    }
    else{
        $insertQuery="INSERT INTO users(firstName,lastName,email,password)
                       VALUES ('$firstName','$lastName','$email','$password')";
        if($conn_users->query($insertQuery) === TRUE){
            header("location: u_login.php");
        }
        else{
            echo "Error: " . $conn_users->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);
    
    $sql="SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result=$conn_users->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['user_id']=$row['Id'];
        $_SESSION['email']=$row['email'];
        $_SESSION['firstName']=$row['firstName'];
        $_SESSION['lastName']=$row['lastName'];
        header("Location: u_login_success.php");
        exit();
    }
    else{
        header("Location: u_login.php?error=login_failed");
        exit();
    }
}
?>