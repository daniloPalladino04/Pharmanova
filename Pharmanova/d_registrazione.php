<?php 
include 'd_connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password=md5($password);
}

if(isset($_POST['signIn'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password=md5($password);
    
    $sql="SELECT * FROM employees WHERE username='$username' and password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['username']=$row['username'];
        $_SESSION['firstName']=$row['firstName'];
        $_SESSION['lastName']=$row['lastName'];
        header("Location: d_login_success.php");
        exit();
    }
    else{
        header("Location: d_login.php?error=login_failed");
        exit();
    }
}
?>