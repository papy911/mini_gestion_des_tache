<?php
$id_recherche = $_GET['id'];
$taches = json_decode(file_get_contents('tasks.json'), true);

foreach ($taches as &$tache) {
    if ($tache['id'] === $id_recherche) {
        if ($tache['statut'] === 'à faire') $tache['statut'] = 'en cours';
        elseif ($tache['statut'] === 'en cours') $tache['statut'] = 'terminée';
        else $tache['statut'] = 'à faire';
    }
}

file_put_contents('tasks.json', json_encode($taches, JSON_PRETTY_PRINT));
header('Location: index.php');