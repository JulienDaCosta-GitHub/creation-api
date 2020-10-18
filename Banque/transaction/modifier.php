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
include_once '../../models/Transaction.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les produits
$transaction = new Transaction($db);

// On récupère les données reçues
$donnees = json_decode(file_get_contents("php://input"));

// On vérifie qu'on a bien toutes les données
if(!empty($donnees->date) && !empty($donnees->montant) && !empty($donnees->valide) && !empty($donnees->moyenPaiement) && !empty($donnees->compte_id)){
// On hydrate notre objet
$transaction->id = $donnees->id;
$transaction->date = $donnees->date;
$transaction->montant = $donnees->montant;
$transaction->valide = $donnees->valide;
$transaction->moyenPaiement = $donnees->moyenPaiement;
$transaction->compte_id = $donnees->compte_id;

if($transaction->modifier()){
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