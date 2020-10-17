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

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

// On inclut les fichiers de configuration et d'accès aux données
include_once '../../config/Database.php';
include_once '../../models/Cb.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les users
$user = new User($db);

$donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $cb->id = $donnees->cb;

        // On récupère le user
        $cb->lireUn();

        // On vérifie si le user existe
        if($cb->uuid != null){

            $ctab = [
                "uuid" => $user->id,
                "exp" => $user->nom,
                "cryptogramme" => $user->email,
                "code" => $user->password,
                "active" => $user->password,
                "user_id" => $user->password,
                "compte_id" => $user->password,
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($ctab);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "L'user' n'existe pas."));
        }
    }