<?php
session_start();
require_once '../Controller/UserController.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "User ID is missing.";
    exit();
}

$userController = new UserController();
$userController->deleteUser($_GET['id']);

header("Location: admin_users.php");
exit();
?>
