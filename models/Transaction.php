<?php

class Transaction{
    // Connexion
    private $connexion;
    private $table = "transaction"; // Table dans la base de données

    // Transactions
    public $id;
    public $date;
    public $montant;
    public $valide;
    public $moyenPaiement;
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
 * Créer une transaction
 *
 * @return void
 */
public function creer(){

    // Ecriture de la requête SQL en y insérant le nom de la table
    $sql = "INSERT INTO " . $this->table . " SET date=:date, montant=:montant, valide=:valide, moyenPaiement=:moyenPaiement, compte_id=:compte_id";

    // Préparation de la requête
    $query = $this->connexion->prepare($sql);

    // Protection contre les injections
    $this->date=htmlspecialchars(strip_tags($this->date));
    $this->montant=htmlspecialchars(strip_tags($this->montant));
    $this->valide=htmlspecialchars(strip_tags($this->valide));
    $this->moyenPaiement=htmlspecialchars(strip_tags($this->moyenPaiement));
    $this->compte_id=htmlspecialchars(strip_tags($this->compte_id));

    // Ajout des données protégées
    $query->bindParam(":date", $this->date);
    $query->bindParam(":montant", $this->montant);
    $query->bindParam(":valide", $this->valide);
    $query->bindParam(":moyenPaiement", $this->moyenPaiement);
    $query->bindParam(":compte_id", $this->compte_id);

    // Exécution de la requête
    if($query->execute()){
        return true;
    }
    return false;
}

/**
 * Lecture des transactions
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
 * Lire une transaction
 *
 * @return void
 */
public function lireUn(){
     // On écrit la requête
     $sql = "SELECT date, montant, valide, moyenPaiement, compte_id FROM " . $this->table . " WHERE id = ? LIMIT 0,1";

     // On prépare la requête
     $query = $this->connexion->prepare( $sql );
 
     // On attache l'id
     $query->bindParam(1, $this->id);
 
     // On exécute la requête
     $query->execute();
 
     // on récupère la ligne
     $row = $query->fetch(PDO::FETCH_ASSOC);
 
     // On hydrate l'objet
     $this->date = $row['date'];
     $this->montant = $row['montant'];
     $this->valide = $row['valide'];
     $this->moyenPaiement = $row['moyenPaiement'];
     $this->compte_id = $row['compte_id'];
}

/**
 * Mettre à jour une transaction
 *
 * @return void
 */
public function modifier(){
    // On écrit la requête
    $sql = "UPDATE " . $this->table . " SET date = :date, montant = :montant, valide = :valide, moyenPaiement = :moyenPaiement, compte_id = :compte_id WHERE id = :id";
    
    // On prépare la requête
    $query = $this->connexion->prepare($sql);
    
    // On sécurise les données
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->date=htmlspecialchars(strip_tags($this->date));
    $this->montant=htmlspecialchars(strip_tags($this->montant));
    $this->valide=htmlspecialchars(strip_tags($this->valide));
    $this->moyenPaiement=htmlspecialchars(strip_tags($this->moyenPaiement));
    $this->compte_id=htmlspecialchars(strip_tags($this->compte_id));
    
    // On attache les variables
    $query->bindParam(':id', $this->id);
    $query->bindParam(":date", $this->date);
    $query->bindParam(":montant", $this->montant);
    $query->bindParam(":valide", $this->valide);
    $query->bindParam(":moyenPaiement", $this->moyenPaiement);
    $query->bindParam(":compte_id", $this->compte_id);
    
    // On exécute
    if($query->execute()){
        return true;
    }
    
    return false;
}

/**
 * Supprimer une transaction
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

