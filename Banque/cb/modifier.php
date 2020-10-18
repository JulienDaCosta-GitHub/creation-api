<?php

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: PUT");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    // La bonne méthode est utilisée

    include_once '../../config/Database.php';
include_once '../../models/User.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les cb
$cb = new Cb($db);

// On récupère les données reçues
$donnees = json_decode(file_get_contents("php://input"));

// On vérifie qu'on a bien toutes les données
if(!empty($donnees->id) && !empty($donnees->uuid) && !empty($donnees->exp) && !empty($donnees->cryptogramme) && !empty($donnees->code) && !empty($donnees->active) && !empty($donnees->user_id) && !empty($donnees->compte_id)){
// On hydrate notre objet
$cb->id = $donnees->id;
$cb->uuid = $donnees->uuid;
$cb->exp = $donnees->exp;
$cb->cryptogramme = $donnees->cryptogramme;
$cb->code = $donnees->code;
$cb->active = $donnees->active;
$cb->user_id = $donnees->user_id;
$cb->compte_id = $donnees->compte_id;

if($cb->modifier()){
    // Ici la modification a fonctionné
    // On envoie un code 200
    http_response_code(200);
    echo json_encode(["message" => "La modification a été effectuée"]);
}else{
    // Ici la création n'a pas fonctionné
    // On envoie un code 503
    http_response_code(503);
    echo json_encode(["message" => "La modification n'a pas été effectuée"]);         
}

}

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}