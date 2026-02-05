<?php
$donnees_json = file_get_contents('tasks.json');
$taches = json_decode($donnees_json, true) ?: [];

$recherche = $_GET['recherche'] ?? '';
$filtre_statut = $_GET['filtre_statut'] ?? '';

$taches_affichees = array_filter($taches, function($tache) use ($recherche, $filtre_statut) {
    $match_texte = empty($recherche) || stripos($tache['titre'], $recherche) !== false;
    $match_statut = empty($filtre_statut) || $tache['statut'] == $filtre_statut;
    return $match_texte && $match_statut;
});

$total = count($taches);
$terminees = count(array_filter($taches, fn($t) => $t['statut'] == 'terminée'));
$pourcentage = $total > 0 ? round(($terminees / $total) * 100) : 0;
$en_retard = count(array_filter($taches, fn($t) => $t['statut'] != 'terminée' && strtotime($t['date_limite']) < time()));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GESTION DES TACHE L2 IAGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="d-flex">
        <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
            
            <h4> <img  src="WhatsApp Image 2025-11-11 à 17.21.34_d5a3dd94.jpg" alt="Photo de profil" class="photo-profil"> PAPA OMAR NDIAYE L2 IAGE</h4>
            <hr>
            <a href="index.php" class="btn btn-primary w-100 mb-2">Tableau de bord</a>
            <a href="add.php" class="btn btn-outline-light w-100">Ajouter une tâche</a>
        </div>

        <div class="p-4 w-100 bg-light">
            <h2>Statistiques </h2>
            <div class="row mb-4 text-white text-center">
                <div class="col-md-3"><div class="p-3 bg-info"><h3><?= $total ?></h3> Total</div></div>
                <div class="col-md-3"><div class="p-3 bg-success"><h3><?= $terminees ?></h3> Terminées</div></div>
                <div class="col-md-3"><div class="p-3 bg-warning"><h3><?= $pourcentage ?>%</h3> Succès</div></div>
                <div class="col-md-3"><div class="p-3 bg-danger"><h3><?= $en_retard ?></h3> En Retard</div></div>
            </div>

            <form class="row g-2 mb-4">
                <div class="col-md-6"><input type="text" name="recherche" class="form-control" placeholder="Titre ou description..."></div>
                <div class="col-md-4">
                    <select name="filtre_statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="à faire">À faire</option>
                        <option value="en cours">En cours</option>
                        <option value="terminée">Terminée</option>
                    </select>
                </div>
                <div class="col-md-2"><button class="btn btn-dark w-100">Filtrer</button></div>
            </form>

            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Titre</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Date Limite</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($taches_affichees as $tache): 
                        $alerte_retard = ($tache['statut'] != 'terminée' && strtotime($tache['date_limite']) < time());
                    ?>
                    <tr class="<?= $alerte_retard ? 'table-danger' : '' ?>">
                        <td><strong><?= $tache['titre'] ?></strong></td>
                        <td><?= $tache['priorite'] ?></td>
                        <td><span class="badge bg-primary"><?= $tache['statut'] ?></span></td>
                        <td><?= $tache['date_limite'] ?> <?= $alerte_retard ? ' <strong>RETARD</strong>' : '' ?></td>
                        <td>
                            <a href="status.php?id=<?= $tache['id'] ?>" class="btn btn-sm btn-info">Changer Statut</a>
                            <a href="delete.php?id=<?= $tache['id'] ?>" class="btn btn-sm btn-danger">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>