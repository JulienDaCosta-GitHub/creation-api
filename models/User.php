<?php

class User{
    // Connexion
    private $connexion;
    private $table = "user"; // Table dans la base de données

    // Users
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;

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
    $sql = "INSERT INTO " . $this->table . " SET nom=:nom, prenom=:prenom, email=:email, password=:password";

    // Préparation de la requête
    $query = $this->connexion->prepare($sql);

    // Protection contre les injections
    $this->nom=htmlspecialchars(strip_tags($this->nom));
    $this->prenom=htmlspecialchars(strip_tags($this->prenom));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));

    // Ajout des données protégées
    $query->bindParam(":nom", $this->nom);
    $query->bindParam(":prenom", $this->prenom);
    $query->bindParam(":email", $this->email);
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
     $sql = "SELECT nom, prenom, email, password FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

     // On prépare la requête
     $query = $this->connexion->prepare( $sql );
 
     // On attache l'id
     $query->bindParam(1, $this->id);
 
     // On exécute la requête
     $query->execute();
 
     // on récupère la ligne
     $row = $query->fetch(PDO::FETCH_ASSOC);
 
     // On hydrate l'objet
     $this->nom = $row['nom'];
     $this->prenom = $row['prenom'];
     $this->email = $row['email'];
     $this->password = $row['password'];
}

/**
 * Mettre à jour un user
 *
 * @return void
 */
public function modifier(){
    // On écrit la requête
    $sql = "UPDATE " . $this->table . " SET nom = :nom, prenom = :prenom, email = :email, password = :password WHERE id = :id";
    
    // On prépare la requête
    $query = $this->connexion->prepare($sql);
    
    // On sécurise les données
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->nom=htmlspecialchars(strip_tags($this->nom));
    $this->prenom=htmlspecialchars(strip_tags($this->prenom));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
    
    // On attache les variables
    $query->bindParam(':id', $this->id);
    $query->bindParam(':nom', $this->nom);
    $query->bindParam(':prenom', $this->prenom);
    $query->bindParam(':email', $this->email);
    $query->bindParam(':password', $this->password);
    
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

