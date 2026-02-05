<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taches = json_decode(file_get_contents('tasks.json'), true) ?: [];

    $nouvelle_tache = [
        "id" => uniqid(),
        "titre" => $_POST['titre'],
        "description" => $_POST['description'],
        "priorite" => $_POST['priorite'],
        "statut" => "à faire", 
        "date_creation" => date('Y-m-d H:i'), 
        "date_limite" => $_POST['date_limite']
    ];

    $taches[] = $nouvelle_tache;
    file_put_contents('tasks.json', json_encode($taches, JSON_PRETTY_PRINT));
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header bg-primary text-white"><h4>Ajouter une tâche</h4></div>
        <form method="POST" class="card-body">
            <label>Titre</label>
            <input type="text" name="titre" class="form-control mb-3" required>
            
            <label>Description</label>
            <textarea name="description" class="form-control mb-3"></textarea>
            
            <label>Priorité </label>
            <select name="priorite" class="form-select mb-3">
                <option value="basse">Basse</option>
                <option value="moyenne">Moyenne</option>
                <option value="haute">Haute</option>
            </select>
            
            <label>Date Limite </label>
            <input type="date" name="date_limite" class="form-control mb-4" required>
            
            <button type="submit" class="btn btn-success w-100">Enregistrer la tâche</button>
            <a href="index.php" class="btn btn-link w-100 mt-2">Retour au dashboard</a>
        </form>
    </div>
</body>
</html>