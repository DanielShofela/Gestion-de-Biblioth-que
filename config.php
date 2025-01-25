<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliothèquedb";

try {
    // Création de la connexion
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->exec("SET NAMES utf8");

    // Création de la table categories
    $sql_categories = "CREATE TABLE IF NOT EXISTS categories (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nom VARCHAR(100) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $bdd->exec($sql_categories);

    // Insertion des catégories par défaut
    $categories_default = [
        'Roman', 'Science-Fiction', 'Policier', 'Biographie', 
        'Histoire', 'Sciences', 'Informatique', 'Autre'
    ];

    $insert_cat = $bdd->prepare("INSERT IGNORE INTO categories (nom) VALUES (?)");
    foreach($categories_default as $categorie) {
        $insert_cat->execute([$categorie]);
    }

    // Création de la table livres
    $sql_livres = "CREATE TABLE IF NOT EXISTS livres (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        titre VARCHAR(255) NOT NULL,
        auteur VARCHAR(255) NOT NULL,
        categorie_id INT,
        annee_publication INT,
        description TEXT,
        date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (categorie_id) REFERENCES categories(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $bdd->exec($sql_livres);

} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>