<?php
require_once "config.php";

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = trim($_GET["id"]);
    
    $sql = "SELECT l.*, c.nom as categorie_nom 
            FROM livres l 
            LEFT JOIN categories c ON l.categorie_id = c.id 
            WHERE l.id = :id";
    
    if($stmt = $bdd->prepare($sql)){
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                $livre = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $titre = $livre["titre"];
                $auteur = $livre["auteur"];
                $categorie = $livre["categorie_nom"];
                $annee_publication = $livre["annee_publication"];
                $description = $livre["description"]; 
            } else{
                header("location: index.php");
                exit();
            }
        } else{
            echo "Une erreur s'est produite.";
        }
    }
} else{
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voir le Livre</title>
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
                    <h1 class="mt-5 mb-3">Voir le Livre</h1>
                    <div class="form-group">
                        <label>Titre</label>
                        <p class="form-control-static"><?= htmlspecialchars($titre); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Auteur</label>
                        <p class="form-control-static"><?= htmlspecialchars($auteur); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Catégorie</label>
                        <p class="form-control-static"><?= htmlspecialchars($categorie ?? 'Non catégorisé'); ?></p>
                    </div>
                    <div class="form-group">
                        <label>Année de publication</label>
                        <p class="form-control-static"><?= $annee_publication ? htmlspecialchars($annee_publication) : 'Non spécifié'; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <p class="form-control-static"><?= nl2br(htmlspecialchars($description ?? '')); ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Retour</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
