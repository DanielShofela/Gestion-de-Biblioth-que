<?php
require_once "config.php";

// Récupération des filtres
$stmt_categories = $bdd->query("SELECT * FROM categories ORDER BY nom");
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

$stmt_years = $bdd->query("SELECT DISTINCT annee_publication FROM livres WHERE annee_publication IS NOT NULL ORDER BY annee_publication DESC");
$years = $stmt_years->fetchAll(PDO::FETCH_COLUMN);

$stmt_authors = $bdd->query("SELECT DISTINCT auteur FROM livres WHERE auteur IS NOT NULL ORDER BY auteur");
$authors = $stmt_authors->fetchAll(PDO::FETCH_COLUMN);

// Construction de la requête
$sql = "SELECT l.*, c.nom as categorie_nom FROM livres l LEFT JOIN categories c ON l.categorie_id = c.id";
$where_clauses = array();
$params = array();

if(isset($_GET['categorie']) && $_GET['categorie'] !== "") {
    $where_clauses[] = "l.categorie_id = :categorie_id";
    $params[':categorie_id'] = $_GET['categorie'];
}

if(isset($_GET['annee']) && $_GET['annee'] !== "") {
    $where_clauses[] = "l.annee_publication = :annee";
    $params[':annee'] = $_GET['annee'];
}

if(isset($_GET['auteur']) && $_GET['auteur'] !== "") {
    $where_clauses[] = "l.auteur = :auteur";
    $params[':auteur'] = $_GET['auteur'];
}

if (!empty($where_clauses)) {
    $sql .= " WHERE " . implode(" AND ", $where_clauses);
}

// Gestion du tri
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_ajout';
switch($sort) {
    case 'auteur':
        $sql .= " ORDER BY l.auteur";
        break;
    case 'categorie':
        $sql .= " ORDER BY c.nom";
        break;
    case 'annee':
        $sql .= " ORDER BY l.annee_publication";
        break;
    default:
        $sql .= " ORDER BY l.date_ajout DESC";
}
try {
    $stmt = $bdd->prepare($sql);
    foreach($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bibliothèque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body{ padding: 20px; }
        .wrapper{ width: 100%; padding: 20px; }
        .book-actions{ white-space: nowrap; }
        .filters { background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="float-left">Liste des Livres</h2>
                        <a href="ajouter.php" class="btn btn-success float-right">
                            <i class="fa fa-plus"></i> Ajouter un Livre
                        </a>
                    </div>
                    
                    <!-- Filtres -->
                    <div class="filters">
                                          <!-- Tableau des résultats -->
                                          <?php 
                                          // S'assurer que $result est toujours un tableau
                                          if (!isset($result)) {
                                              $result = array();
                                          }
                                          ?>
                                          <table class="table table-bordered table-striped">
                                              <thead>
                                                  <tr>
                                                      <th>Titre</th>
                                                      <th>
                                                          <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'auteur'])) ?>" class="text-dark">
                                                              Auteur <i class="fa fa-sort"></i>
                                                          </a>
                                                      </th>
                                                      <th>
                                                          <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'categorie'])) ?>" class="text-dark">
                                                              Catégorie <i class="fa fa-sort"></i>
                                                          </a>
                                                      </th>
                                                      <th>
                                                          <a href="?<?= http_build_query(array_merge($_GET, ['sort' => 'annee'])) ?>" class="text-dark">
                                                              Année <i class="fa fa-sort"></i>
                                                          </a>
                                                      </th>
                                                      <th>Actions</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                              <?php if(count($result) > 0): ?>
                                                  <?php foreach($result as $row): ?>
                                                      <tr>
                                                          <td><?= htmlspecialchars($row['titre']) ?></td>
                                                          <td><?= htmlspecialchars($row['auteur']) ?></td>
                                                          <td><?= htmlspecialchars($row['categorie_nom'] ?? 'Non catégorisé') ?></td>
                                                          <td><?= $row['annee_publication'] ? htmlspecialchars($row['annee_publication']) : '-' ?></td>
                                                          <td class="book-actions">
                                                              <a href="voir.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm" title="Voir">
                                                                  <i class="fa fa-eye"></i>
                                                              </a>
                                                              <a href="modifier.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Modifier">
                                                                  <i class="fa fa-pencil"></i>
                                                              </a>
                                                              <a href="supprimer.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" title="Supprimer">
                                                                  <i class="fa fa-trash"></i>
                                                              </a>
                                                          </td>
                                                      </tr>
                                                  <?php endforeach; ?>
                                              <?php else: ?>
                                                  <tr>
                                                      <td colspan="5" class="text-center">Aucun livre trouvé</td>
                                                  </tr>
                                              <?php endif; ?>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>        
                              </div>
                          </div>
                      </body>
                      </html>