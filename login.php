<?php

require_once 'config/database.php';
session_start();

$errors = [];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = htmlspecialchars(trim($_POST['email'])) ?? '';
    $password = $_POST['password'] ?? '';
    
    
    // gestion des erreurs
    if(empty($email)){
      $errors[] = "vous n'avez pas renseigné l'email";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors[] = "format classique email non respecté";
    }


    if(empty($password)){
      $errors[] = "vous n'avez pas renseigné le password";
    }
    

    if(empty($errors)){

      try{

        // on lance la connexion à la BD
        $pdo = dbConnexion();

        //preparation et execution de la requete
        $sql = "SELECT * FROM users WHERE email = ?";
        $request = $pdo->prepare($sql);
        $request->execute([$email]);

        //recuperation du resultat sous forme de tableau associatif
        $user = $request->fetch(); 

        if($user)
        {
          // on verifie si le password est le bon password_verify decripte le $hash
            if (password_verify($password, $user['password'])) {
                $message = "Connexion réussie !";

                $_SESSION["user_id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                $_SESSION["email"] = $user['email'];
                $_SESSION["loggin"] = true;

                // Redirige vers une autre page
                header('Location: home.php');
                exit();

            } else {
                $errors[] = "Mot de passe incorrect";
            }

        }

        else{ 
          $errors[] = "Compte inexistant";
        }

      } catch (PDOException $e) {
        $errors[] = "Erreur durant la connexion à la bd: ".$e->getMessage();
      }
             
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

    <h2>Connexion</h2>
    <form action="" method="POST">

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Connexion</button>
    </form>
    </div>
    </main>
    
</body>
</html>