<?php

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: GET");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // La bonne méthode est utilisée

    // On inclut les fichiers de configuration et d'accès aux données
include_once '../../config/Database.php';
include_once '../../models/User.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les users
$user = new User($db);

// On récupère les données
$stmt = $user->lire();

// On vérifie si on a au moins 1 user
if($stmt->rowCount() > 0){
    // On initialise un tableau associatif
    $tableauUsers = [];
    $tableauUsers['users'] = [];

    // On parcourt les users
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $us = [
            "id" => $id,
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "password" => $password
        ];

        $tableauUsers['users'][] = $us;
    }
    // On envoie le code réponse 200 OK
    http_response_code(200);

    // On encode en json et on envoie
    echo json_encode($tableauUsers);
}

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

