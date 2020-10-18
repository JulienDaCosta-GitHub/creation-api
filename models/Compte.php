<?php

class Compte{
    // Connexion
    private $connexion;
    private $table = "compte"; // Table dans la base de données

    // Compte
    public $id;
    public $user_id;
    public $fonds;
    public $type;
    public $actif;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
 * Créer un compte
 *
 * @return void
 */
public function creer(){

    // Ecriture de la requête SQL en y insérant le nom de la table
    $sql = "INSERT INTO " . $this->table . " SET user_id=:user_id, fonds=:fonds, type=:type, actif=:actif";

    // Préparation de la requête
    $query = $this->connexion->prepare($sql);

    // Protection contre les injections
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->fonds=htmlspecialchars(strip_tags($this->fonds));
    $this->type=htmlspecialchars(strip_tags($this->type));
    $this->actif=htmlspecialchars(strip_tags($this->actif));

    // Ajout des données protégées
    $query->bindParam(":user_id", $this->user_id);
    $query->bindParam(":fonds", $this->fonds);
    $query->bindParam(":type", $this->type);
    $query->bindParam(":actif", $this->actif);

    // Exécution de la requête
    if($query->execute()){
        return true;
    }
    return false;
}

/**
 * Lecture des comptes
 *
 * @return void
 */
public function lire(){
    // On écrit la requête
    $sql = "SELECT * FROM $this->table";

    // On prépare la requête
    $query = $this->connexion->prepare($sql);

    // On exécute la requête
    $query->execute();

    // On retourne le résultat
    return $query;
}

/**
 * Lire un compte
 *
 * @return void
 */
public function lireUn(){
     // On écrit la requête
     $sql = "SELECT user_id, fonds, type, actif FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

     // On prépare la requête
     $query = $this->connexion->prepare( $sql );
 
     // On attache l'id
     $query->bindParam(1, $this->id);
 
     // On exécute la requête
     $query->execute();
 
     // on récupère la ligne
     $row = $query->fetch(PDO::FETCH_ASSOC);
 
     // On hydrate l'objet
     $this->user_id = $row['user_id'];
     $this->fonds = $row['fonds'];
     $this->type = $row['type'];
     $this->actif = $row['actif'];
}

/**
 * Mettre à jour un compte
 *
 * @return void
 */
public function modifier(){
    // On écrit la requête
    $sql = "UPDATE " . $this->table . " SET user_id = :user_id, fonds = :fonds, type = :type, actif = :actif WHERE id = :id";
    
    // On prépare la requête
    $query = $this->connexion->prepare($sql);
    
    // On sécurise les données
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->fonds=htmlspecialchars(strip_tags($this->fonds));
    $this->type=htmlspecialchars(strip_tags($this->type));
    $this->actif=htmlspecialchars(strip_tags($this->actif));
    
    // On attache les variables
    $query->bindParam(':id', $this->id);
    $query->bindParam(':user_id', $this->user_id);
    $query->bindParam(':fonds', $this->fonds);
    $query->bindParam(':type', $this->type);
    $query->bindParam(':actif', $this->actif);
    
    // On exécute
    if($query->execute()){
        return true;
    }
    
    return false;
}

/**
 * Supprimer un compte
 *
 * @return void
 */
public function supprimer(){
    // On écrit la requête
    $sql = "DELETE FROM " . $this->table . " WHERE id = ?";

    // On prépare la requête
    $query = $this->connexion->prepare( $sql );

    // On sécurise les données
    $this->id=htmlspecialchars(strip_tags($this->id));

    // On attache l'id
    $query->bindParam(1, $this->id);

    // On exécute la requête
    if($query->execute()){
        return true;
    }
    
    return false;
}
}

