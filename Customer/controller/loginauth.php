<?php
include "../model/DatabaseConnection.php";
session_start();

$email = $_REQUEST["email"] ?? "";
$password = $_REQUEST["password"] ?? "";

$errors = [];
$values = [];

if(!$email){
    $errors["email"] = "Email field is required";
}

if(!$password){
    $errors["password"] = "Password field is required";
}

if(count($errors) > 0){

    if(isset($errors["email"])){
        $_SESSION["emailErr"] = $errors["email"];
    }

    if(isset($errors["password"])){
        $_SESSION["passwordErr"] = $errors["password"];
    }

    $values["email"] = $email;
    $_SESSION["previousValues"] = $values;

    header("Location: ../view/login.php");
    exit;
}



$db = new DatabaseConnection();
$connection = $db->openConnection();


$sql = "SELECT * FROM users WHERE email='$email'";
$result = $connection->query($sql);

if($result && $result->num_rows == 1){

    $data = $result->fetch_assoc();

 
    if(password_verify($password, $data["password"])){

        $_SESSION["email"] = $data["email"];
        $_SESSION["isLoggedIn"] = true;

        header("Location: ../User/view/dashboard.php");
        exit;

    }else{
        $_SESSION["LoginErr"] = "Email or password is incorrect";
        header("Location: ../view/login.php");
        exit;
    }

}else{
    $_SESSION["LoginErr"] = "Email or password is incorrect";
    header("Location: ../view/login.php");
    exit;
}