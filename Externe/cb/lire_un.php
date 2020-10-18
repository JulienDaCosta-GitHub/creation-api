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
include_once '../../models/Cb.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les users
$cb = new Cb($db);

$donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $cb->id = $donnees->id;

        // On récupère le user
        $cb->lireUn();

        // On vérifie si la cb existe
        if($cb->uuid != null){

            $ctab = [
                "id" => $cb->id,
                "uuid" => $cb->uuid,
                "exp" => $cb->exp,
                "cryptogramme" => $cb->cryptogramme,
                "code" => $cb->code,
                "active" => $cb->active,
                "user_id" => $cb->user_id,
                "compte_id" => $cb->compte_id,
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($ctab);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "La cb n'existe pas."));
        }
    }

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}