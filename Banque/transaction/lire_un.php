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
include_once '../../models/Transaction.php';

// On instancie la base de données
$database = new Database();
$db = $database->getConnection();

// On instancie les users
$transaction = new Transaction($db);

$donnees = json_decode(file_get_contents("php://input"));

    if(!empty($donnees->id)){
        $transaction->id = $donnees->id;

        // On récupère le user
        $transaction->lireUn();

        // On vérifie si le user existe
        if($transaction->compte_id != null){

            $tt = [
                "id" => $transaction->id,
                "date" => $transaction->date,
                "montant" => $transaction->montant,
                "valide" => $transaction->valide,
                "moyenPaiement" => $transaction->moyenPaiement,
                "compte_id" => $transaction->compte_id,
            ];
            // On envoie le code réponse 200 OK
            http_response_code(200);

            // On encode en json et on envoie
            echo json_encode($tt);
        }else{
            // 404 Not found
            http_response_code(404);
         
            echo json_encode(array("message" => "La transaction' n'existe pas."));
        }
    }