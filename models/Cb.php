<?php

class Cb{
    // Connexion
    private $connexion;
    private $table = "cb"; // Table dans la base de données

    // Users
    public $id;
    public $uuid;
    public $exp;
    public $cryptogramme;
    public $code;
    public $active;
    public $user_id;
    public $compte_id;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
 * Créer un user
 *
 * @return void
 */
public function creer(){

    // Ecriture de la requête SQL en y insérant le nom de la table
    $sql = "INSERT INTO " . $this->table . " SET uuid=:uuid, exp=:exp, cryptogramme=:cryptogramme, code=:code, active=:active, user_id=:user_id, compte_id=:compte_id";

    // Préparation de la requête
    $query = $this->connexion->prepare($sql);

    // Protection contre les injections
    $this->uuid=htmlspecialchars(strip_tags($this->uuid));
    $this->exp=htmlspecialchars(strip_tags($this->exp));
    $this->cryptogramme=htmlspecialchars(strip_tags($this->cryptogramme));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->active=htmlspecialchars(strip_tags($this->active));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->compte_id=htmlspecialchars(strip_tags($this->compte_id));

    // Ajout des données protégées
    $query->bindParam(":uuid", $this->uuid);
    $query->bindParam(":exp", $this->exp);
    $query->bindParam(":cryptogramme", $this->cryptogramme);
    $query->bindParam(":code", $this->code);
    $query->bindParam(":active", $this->active);
    $query->bindParam(":user_id", $this->user_id);
    $query->bindParam(":compte_id", $this->compte_id);

    // Exécution de la requête
    if($query->execute()){
        return true;
    }
    return false;
}

/**
 * Lecture des users
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
 * Lire un user
 *
 * @return void
 */
public function lireUn(){
     // On écrit la requête
     $sql = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

     // On prépare la requête
     $query = $this->connexion->prepare( $sql );
 
     // On attache l'id
     $query->bindParam(1, $this->id);
 
     // On exécute la requête
     $query->execute();
 
     // on récupère la ligne
     $row = $query->fetch(PDO::FETCH_ASSOC);
 
     // On hydrate l'objet
     $this->uuid = $row['uuid'];
     $this->exp = $row['exp'];
     $this->cryptogramme = $row['cryptogramme'];
     $this->code = $row['code'];
     $this->active = $row['active'];
     $this->user_id = $row['user_id'];
     $this->compte_id = $row['compte_id'];
}

/**
 * Mettre à jour un user
 *
 * @return void
 */
public function modifier(){
    // On écrit la requête
    $sql = "UPDATE " . $this->table . " SET uuid = :uuid, exp = :exp, cryptogramme = :cryptogramme, code = :code, active = :active, user_id = :user_id, compte_id = :compte_id WHERE id = :id";
    
    // On prépare la requête
    $query = $this->connexion->prepare($sql);
    
    // On sécurise les données
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->uuid=htmlspecialchars(strip_tags($this->uuid));
    $this->exp=htmlspecialchars(strip_tags($this->exp));
    $this->cryptogramme=htmlspecialchars(strip_tags($this->cryptogramme));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->active=htmlspecialchars(strip_tags($this->active));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->compte_id=htmlspecialchars(strip_tags($this->compte_id));
    
    // On attache les variables
    $query->bindParam(':id', $this->id);
    $query->bindParam(':uuid', $this->uuid);
    $query->bindParam(':exp', $this->exp);
    $query->bindParam(':cryptogramme', $this->cryptogramme);
    $query->bindParam(':code', $this->code);
    $query->bindParam(':active', $this->active);
    $query->bindParam(':user_id', $this->user_id);
    $query->bindParam(':compte_id', $this->compte_id);
    
    // On exécute
    if($query->execute()){
        return true;
    }
    
    return false;
}

/**
 * Supprimer un user
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