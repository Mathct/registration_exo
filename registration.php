<?php

require_once 'config/database.php';


$errors = [];
$message = "";

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
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors[] = "format classique email non respecté";
    }
    elseif(strlen($email) > 50){
      $errors[] = "l'email doit comporter moins de 50 caractères";
    }

  

    if(empty($password)){
      $errors[] = "vous n'avez pas renseigné le password";
    }

      // il faudra rajouter le regex pour mdp

    elseif($password !== $confirmpassword){
      $errors[] = "vous n'avez pas correctement confirmé le password";
    }
    elseif($password !== $confirmpassword){
      $errors[] = "vous n'avez pas correctement confirmé le password";
    }
    elseif(strlen($password) <3){
      $errors[] = "le mdp doit comporter plus de 3 caractères";
    }
    elseif(strlen($password) > 20){
      $errors[] = "le mdp doit comporter moins de 20 caractères";
    }


    

    if(empty($errors)){

        // Nettoyage des données (on ne nettoie pas le password car il sera cripté)
        $username = htmlspecialchars(trim($username));
        $email = htmlspecialchars(trim($email));

        // on lance la connexion à la BD
        $pdo = dbConnexion();

        //verification que l'email est unique
        //on prepare la requete SQL
        $checkEmail =  $pdo->prepare("SELECT id FROM users WHERE email = ?");
        //on execute la requete SQL
        $checkEmail->execute([$email]);

        //rowCount() permet juste de connaitre le nombre d'element retournés (pas le contenu.. le contenu doit etre fait avec un fetch)
        if ($checkEmail->rowCount() > 0) {
        // Email déjà utilisé
          $errors[] = "Mail déjà utilisé";
        }
        else{
          // haschage du mdp
          $hashPassword = password_hash($password, PASSWORD_DEFAULT);

          // on va injecter les données dans le BD

          $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

          $newUser = $pdo->prepare($sql);

          $newUser->execute([
            ':username'  => $username,
            ':email'      => $email,
            ':password'   => $hashPassword,  // hashé avec password_hash()
          ]);

        }

        $message = "Merci poour votre inscription ".$username;

    
    
    }

    

}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/style/style.css">
</head>
<body>
<main>
<div class="form-container">

<?php
  foreach ($errors as $error)
  {
    echo $error.'<br>';
  }

  if(!empty($message))
  {
    echo $message;
  }

?>

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