<?php
session_start();
include "../model/DatabaseConnection.php";
include "../model/CustomerModel.php";

$db = new DatabaseConnection();
$conn = $db->openConnection();

$model = new CustomerModel();
$users = $model->getAllUsers($conn);