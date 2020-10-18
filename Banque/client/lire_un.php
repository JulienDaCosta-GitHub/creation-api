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
include_once '../../models/Client.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les users
$client = new Client($db);

$donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $client->id = $donnees->id;

        // On récupère le user
        $client->lireUn();

        // On vérifie si le user existe
        if($client->username != null){

            $clitab = [
                "id" => $client->id,
                "username" => $client->username,
                "password" => $client->password,
                "role" => $client->role,
                "apiKey" => $client->apiKey
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($clitab);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "Le client n'existe pas."));
        }
    }