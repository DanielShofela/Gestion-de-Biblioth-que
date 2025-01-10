<?php
require_once "config.php";

if(isset($_POST["id"]) && !empty(trim($_POST["id"]))){
    $sql = "DELETE FROM livres WHERE id = :id";
    
    if($stmt = $bdd->prepare($sql)){
        $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
        $param_id = trim($_POST["id"]);
        
        if($stmt->execute()){
            header("location: index.php");
            exit();
        } else{
            echo "Une erreur s'est produite.";
        }
    }
} else {
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $sql = "SELECT * FROM livres WHERE id = :id";
        
        if($stmt = $bdd->prepare($sql)){
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            $param_id = trim($_GET["id"]);
            
            if($stmt->execute()){
                $result = $stmt->fetchAll();
    
                if(count($result) == 1){
                    $row = $result[0];
                    
                    $titre = $row["titre"];
                    $auteur = $row["auteur"];
                    $annee_publication = $row["annee_publication"];
                    $description = $row["description"];
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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer le Livre</title>
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
                    <h2 class="mt-5 mb-3">Supprimer le Livre</h2>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?= trim($_GET["id"]); ?>"/>
                            <p>Êtes-vous sûr de vouloir supprimer ce livre ?</p>
                            <p>
                                <input type="submit" value="Oui" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary ml-2">Non</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
