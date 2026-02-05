<?php
$id_recherche = $_GET['id'];
$taches = json_decode(file_get_contents('tasks.json'), true);

$taches_restantes = array_filter($taches, fn($t) => $t['id'] !== $id_recherche);

file_put_contents('tasks.json', json_encode(array_values($taches_restantes), JSON_PRETTY_PRINT));
header('Location: index.php');