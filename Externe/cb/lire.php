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

// On instancie les cb
$cb = new Cb($db);

// On récupère les données
$stmt = $cb->lire();

// On vérifie si on a au moins 1 cb
if($stmt->rowCount() > 0){
    // On initialise un tableau associatif
    $tableauCb = [];
    $tableauCb['cb'] = [];

    // On parcourt les cb
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $cbtab = [
            "id" => $id,
            "uuid" => $uuid,
            "exp" => $exp,
            "cryptogramme" => $cryptogramme,
            "code" => $code,
            "active" => $active,
            "user_id" => $user_id,
            "compte_id" => $compte_id
        ];

        $tableauCb['cb'][] = $cbtab;
    }
    // On envoie le code réponse 200 OK
    http_response_code(200);

    // On encode en json et on envoie
    echo json_encode($tableauCb);
}

}else{
    // Mauvaise méthode, on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}