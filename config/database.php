<?php

//logique de connexion à la base de données

//information pour se connecter
$host = "localhost";
$port = 3306;
$username = "root";
$password = "";
$dbname = "user_db";

$charset = "utf8mb4"; // encodage

//fonction qui crée et renvoi une connexion à la bd

function dbConnexion() {

    //pour acceder aux variables à l'interieur de la fonction.... on transforme les variables en global
    global $host, $port, $username, $password, $dbname, $charset;

    try {

        //parametres de connexion
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset;port=$port";

        //creation objet connexion
        $pdo = new PDO($dsn, $username, $password);

        //comment recuperer des exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //comment me renvoyer les données
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;

    } catch (PDOException $e) {
       die("Erreur durant la connexion à la bd: ".$e->getMessage());
    }

}

dbConnexion();