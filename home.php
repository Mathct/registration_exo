<?php

require_once 'config/database.php';
session_start();

if (!isset($_SESSION['loggin']) || $_SESSION['loggin'] !== true) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? '';
$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';

if(isset($_GET['logout']) && $_GET['logout'] == 1)
{

    session_unset();
    session_destroy();

    //il faudra aussi supprimer les cookies

    header("Location: login.php");
    exit();

}



?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS + Popper (pour les modales, dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<?php echo "Bienvenue " . $username . "<br><br>"; ?>

<a href="home.php?logout=1" class="btn btn-danger">Se déconnecter</a>


    
</body>
</html>