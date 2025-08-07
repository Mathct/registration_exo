<?php

require_once 'config/database.php';


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

      

        // on lance la connexion à la BD
        $pdo = dbConnexion();

        //verification que le compte existe
        $checkEmail =  $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        if ($checkEmail->rowCount() == 0) {
            // le compte n'existe pas
            $errors[] = "Compte inexistant";
        }

        else
        { 
            
            //verification du password//

            //preparation et execution de la requete
            $recupEmail = $pdo->prepare("SELECT password FROM users WHERE email = ?");
            $recupEmail->execute([$email]);

            //recuperation du resultat sous forme de tableau associatif
            $hashEmail = $recupEmail->fetch(); 
            //recuperation de la valeur souhaitée dans le tableau associatif
            $hash = $hashEmail['password'];

            // on verifie si le passwod est le bon password_verify decripte le $hash
            if (password_verify($password, $hash)) {
                $message = "Connexion réussie !";
            } else {
                $errors[] = "Mot de passe incorrect";
            }
       
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