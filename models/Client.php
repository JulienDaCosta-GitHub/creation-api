<?php

class Client{
    // Connexion
    private $connexion;
    private $table = "client"; // Table dans la base de données

    // Users
    public $id;
    public $username;
    public $password;
    public $role;
    public $apiKey;

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
    $sql = "INSERT INTO " . $this->table . " SET username=:username, password=:password, role=:role, apiKey=:apiKey";

    // Préparation de la requête
    $query = $this->connexion->prepare($sql);

    // Protection contre les injections
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->role=htmlspecialchars(strip_tags($this->role));
    $this->apiKey=htmlspecialchars(strip_tags($this->apiKey));

    // Ajout des données protégées
    $query->bindParam(":username", $this->username);
    $query->bindParam(":password", $this->password);
    $query->bindParam(":role", $this->role);
    $query->bindParam(":password", $this->password);

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
     $sql = "SELECT username, password, role, apiKey FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

     // On prépare la requête
     $query = $this->connexion->prepare( $sql );
 
     // On attache l'id
     $query->bindParam(1, $this->id);
 
     // On exécute la requête
     $query->execute();
 
     // on récupère la ligne
     $row = $query->fetch(PDO::FETCH_ASSOC);
 
     // On hydrate l'objet
     $this->nom = $row['username'];
     $this->prenom = $row['password'];
     $this->email = $row['role'];
     $this->apiKey = $row['apiKey'];
}

/**
 * Mettre à jour un user
 *
 * @return void
 */
public function modifier(){
    // On écrit la requête
    $sql = "UPDATE " . $this->table . " SET username = :username, password = :password, role = :role, apiKey = :apiKey WHERE id = :id";
    
    // On prépare la requête
    $query = $this->connexion->prepare($sql);
    
    // On sécurise les données
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->role=htmlspecialchars(strip_tags($this->role));
    $this->apiKey=htmlspecialchars(strip_tags($this->apiKey));
    
    // On attache les variables
    $query->bindParam(':id', $this->id);
    $query->bindParam(':username', $this->username);
    $query->bindParam(':password', $this->password);
    $query->bindParam(':role', $this->role);
    $query->bindParam(':apiKey', $this->apiKey);
    
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

