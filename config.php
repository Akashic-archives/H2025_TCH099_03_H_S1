<?php
session_start();

//Configuration et connexion à la base de données
$host = 'db';
$db = 'mydatabase';
$user = 'user';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erreur de connexion à la base de données: ".$e->getMessage());
}

// Créez un fichier config.php que vous inclurez dans toutes vos pages PHP. Ce
// fichier doit démarrer la session PHP, établir une connexion à la base de données, et
// définir des fonctions permettant de récupérer les données nécessaires (coaches,
// niveaux, lieux) depuis la base pour alimenter dynamiquement les filtres.


// Modifiez vos pages pour que les options des filtres (coaches, niveaux, lieux) soient
// générées dynamiquement en récupérant les données depuis la base de données via
// les fonctions définies dans config.php.

function getNames($pdo, $param, $number){
    $requete = $pdo->query(
        "SELECT * FROM $param"
    );
    $string="";
    for($number;$number>0;$number--){
    $names = $requete->fetch(PDO::FETCH_ASSOC);
    $names=$names["name"];
    $newString = "<option value=\"$names\">$names</option> ";

    $string = $string . $newString;
    }
    return $string;
}