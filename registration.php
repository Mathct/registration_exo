<?php

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';
    
    
    if(empty($username)){
      $errors[] = "vous n'avez pas renseigné le nom";
    }
    elseif(strlen($username) <3){
      $errors[] = "le nom doit comporter plus de 3 caractères";
    }
    elseif(strlen($username) > 50){
      $errors[] = "le nom doit comporter moins de 50 caractères";
    }



    if(empty($email)){
      $errors[] = "vous n'avez pas renseigné l'email";
    }
    if(empty($password) || (empty($confirmpassword))){
      $errors[] = "vous n'avez pas renseigné ou confirmé le password";
    }

    if($password != $confirmpassword){
      $errors[] = "vous n'avez pas correctement confirmé le password";
    }

    // Nettoyage des données

    if(empty($errors)){

        $username = htmlspecialchars(trim($username));
        $email = htmlspecialchars(trim($email));

    
    
    }

    

}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
<div class="form-container">
    <h2>Inscription</h2>
    <form action="" method="POST">
      <label for="username">Name</label>
      <input type="text" id="username" name="username" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <label for="confirmpassword">Confirm Password</label>
      <input type="password" id="confirmpassword" name="confirmpassword" required>

      <button type="submit">Envoyer</button>
    </form>
    </div>
    </main>
    
</body>
</html>