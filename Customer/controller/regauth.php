
<?php
session_start();
include "../model/DatabaseConnection.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$username = $_REQUEST["username"] ?? "";
$password = $_REQUEST["password"] ?? "";
$email    = $_REQUEST["email"] ?? "";
$phn      = $_REQUEST["phn"] ?? "";
$address  = $_REQUEST["add"] ?? "";
$role     = $_REQUEST["role"] ?? "";

$errors = [];
$values = [];



if (!$username) {
    $errors["username"] = "Username is required";
}

if (!$password) {
    $errors["password"] = "Password is required";
}

if (!$email) {
    $errors["email"] = "Email is required";
}

if (!$phn) {
    $errors["phn"] = "Phone number is required";
}

if (!$address) {
    $errors["address"] = "Address is required";
}

if (!$role) {
    $errors["role"] = "Role is required";
}



if (count($errors) > 0) {

    $_SESSION["usernameErr"] = $errors["username"] ?? "";
    $_SESSION["passwordErr"] = $errors["password"] ?? "";
    $_SESSION["emailErr"]    = $errors["email"] ?? "";
    $_SESSION["phnErr"]      = $errors["phn"] ?? "";
    $_SESSION["addressErr"]  = $errors["address"] ?? "";
    $_SESSION["roleErr"]     = $errors["role"] ?? "";

    $values["username"] = $username;
    $values["email"]    = $email;
    $values["phn"]      = $phn;
    $values["add"]      = $address;
    $values["role"]     = $role;

    $_SESSION["previousValues"] = $values;

    header("Location: ../view/reg.php");
    exit;
}



$db = new DatabaseConnection();
$connection = $db->openConnection();



$result = $db->signup(
    $connection,
    "users",
    $username,
    $email,
    $password,
    $phn,
    $address,
    $role
);

if ($result) {
    header("Location: ../view/login.php");
} else {
    $_SESSION["RegisterErr"] = "Registration failed. Please try again.";
    header("Location: ../view/reg.php");
}
exit;
?>
