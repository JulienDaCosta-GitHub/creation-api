<?php

// Headers requis
// Accès depuis n'importe quel site ou appareil (*)
header("Access-Control-Allow-Origin: *");

// Format des données envoyées
header("Content-Type: application/json; charset=UTF-8");

// Méthode autorisée
header("Access-Control-Allow-Methods: POST");

// Durée de vie de la requête
header("Access-Control-Max-Age: 3600");

// Entêtes autorisées
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // La bonne méthode est utilisée

    include_once '../../config/Database.php';
include_once '../../models/Compte.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les produits
$compte = new Compte($db);

// On récupère les données reçues
$donnees = json_decode(file_get_contents("php://input"));

if(!empty($donnees->user_id) && !empty($donnees->fonds) && !empty($donnees->type) && !empty($donnees->actif)){
    // On hydrate notre objet
$compte->user_id= $donnees->user_id;
$compte->fonds = $donnees->fonds;
$compte->type = $donnees->type;
$compte->actif = $donnees->actif;

if($compte->creer()){
    // Ici la création a fonctionné
    // On envoie un code 201
    http_response_code(201);
    echo json_encode(["message" => "L'ajout a été effectué"]);
}else{
    // Ici la création n'a pas fonctionné
    // On envoie un code 503
    http_response_code(503);
    echo json_encode(["message" => "L'ajout n'a pas été effectué"]);         
}

}

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}