<?php        
require_once "config.php";      

$titre = $auteur = $annee_publication = $description = "";
$titre_err = $auteur_err = $annee_err = "";

// Récupération des catégories
$stmt_categories = $bdd->query("SELECT * FROM categories ORDER BY nom");
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validation des champs
    if(empty(trim($_POST["titre"]))) {
        $titre_err = "Veuillez entrer un titre.";
    } else {
        $titre = trim($_POST["titre"]);
    }
    
    if(empty(trim($_POST["auteur"]))) {
        $auteur_err = "Veuillez entrer un auteur.";
    } else {
        $auteur = trim($_POST["auteur"]);
    }
    
    $categorie_id = !empty($_POST["categorie_id"]) ? trim($_POST["categorie_id"]) : null;
    $annee_publication = !empty($_POST["annee_publication"]) ? trim($_POST["annee_publication"]) : null;
    $description = trim($_POST["description"]);
    
    // Si pas d'erreurs, on insère
    if(empty($titre_err) && empty($auteur_err)) {
        $sql = "INSERT INTO livres (titre, auteur, categorie_id, annee_publication, description) VALUES (:titre, :auteur, :categorie_id, :annee_publication, :description)";
        
        if($stmt = $bdd->prepare($sql)){
            $stmt->bindParam(":titre", $titre, PDO::PARAM_STR);
            $stmt->bindParam(":auteur", $auteur, PDO::PARAM_STR);
            $stmt->bindParam(":categorie_id", $categorie_id, PDO::PARAM_INT);
            $stmt->bindParam(":annee_publication", $annee_publication, PDO::PARAM_INT);
            $stmt->bindParam(":description", $description, PDO::PARAM_STR);
            
            if($stmt->execute()){ 
                header("location: index.php");
                exit();
            } else {
                echo "Une erreur s'est produite.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ padding: 20px; }
        .wrapper{ width: 100%; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Ajouter un Livre</h2>
                    <p>Veuillez remplir ce formulaire pour ajouter un nouveau livre à la bibliothèque.</p>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Titre</label>
                            <input type="text" name="titre" class="form-control <?= (!empty($titre_err)) ? 'is-invalid' : ''; ?>" value="<?= $titre; ?>">
                            <span class="invalid-feedback"><?= $titre_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Auteur</label>
                            <input type="text" name="auteur" class="form-control <?= (!empty($auteur_err)) ? 'is-invalid' : ''; ?>" value="<?= $auteur; ?>">
                            <span class="invalid-feedback"><?= $auteur_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Catégorie</label>
                            <select name="categorie_id" class="form-control">
                                <option value="">Sélectionnez une catégorie</option>
                                <?php foreach($categories as $categorie): ?>
                                    <option value="<?= $categorie['id'] ?>">
                                        <?= htmlspecialchars($categorie['nom']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Année de publication</label>
                            <input type="number" name="annee_publication" class="form-control" value="<?= $annee_publication; ?>">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control"><?= $description; ?></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="index.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
