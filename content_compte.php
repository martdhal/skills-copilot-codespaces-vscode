<?php 

$ingredientArray = [];
$recettes = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ingredients'])) {
        $ingredients = $_POST['ingredients'];
        $ingredientArray = explode(',', $ingredients);
        // Supprimer les espaces autour des ingrédients
        $ingredientArray = array_map('trim', $ingredientArray);

        // Connexion à la base de données
        $dbh = Database::connect();

        // Trouver les recettes correspondantes
        $recettes = recette::trouverRecette($dbh, $ingredientArray);
    } elseif (isset($_POST['nom'], $_POST['duree'], $_POST['lien'], $_POST['newIngredients'])) {
        $nom = $_POST['nom'];
        $duree = $_POST['duree'];
        $lien = $_POST['lien'];
        $ingredients = $_POST['newIngredients'];
        $ingredientArray = explode(',', $ingredients);
        $ingredientArray = array_map('trim', $ingredientArray);

        // Connexion à la base de données
        $dbh = Database::connect();

        // Insérer la recette
        if (recette::insererRecette($dbh, $nom, $duree, $lien)) {
            $recetteId = recette::getIdr($dbh, $nom)->id;

            // Insérer les ingrédients et les lier à la recette
            foreach ($ingredientArray as $ingredient) {
                $ingredientId = Ingredient::getId($dbh, $ingredient);
                if (!$ingredientId) {
                    Ingredient::insererIngredient($dbh, $ingredient);
                    $ingredientId = Ingredient::getId($dbh, $ingredient)->id;
                } else {
                    $ingredientId = $ingredientId->id;
                }
                Ingvsrec::ajouterIngredientARecette($dbh, $recetteId, $ingredientId);
            }

            echo "Recette ajoutée avec succès!";
        } else {
            echo "Erreur lors de l'ajout de la recette.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes & Ingrédients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Colonne Recherche de Recettes -->
            <div class="col-md-6">
                <h2>Recherche de Recettes</h2>
                <form action="" method="POST" class="mb-3">
                    <label for="ingredients" class="form-label">Entrez des ingrédients (séparés par des virgules) :</label>
                    <input type="text" id="ingredients" name="ingredients" class="form-control" required>
                    <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
                </form>
                <?php if (isset($recettes) && !empty($recettes)): ?>
                    <h3>Recettes trouvées :</h3>
                    <ul>
                        <?php foreach ($recettes as $recette): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($recette['recette']); ?></strong>
                                <a href="<?php echo htmlspecialchars($recette['Lien']); ?>" target="_blank">Voir la recette</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif (isset($recettes)): ?>
                    <p>Aucune recette trouvée avec les ingrédients fournis.</p>
                <?php endif; ?>
            </div>

            <!-- Colonne Création de Recette -->
            <div class="col-md-6">
                <h2>Créer une Nouvelle Recette</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la recette :</label>
                        <input type="text" id="Nom" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="duree" class="form-label">Durée (en minutes) :</label>
                        <input type="number" id="duree" name="duree" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lien" class="form-label">Lien de préparation :</label>
                        <input type="text" id="Lien" name="lien" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="newIngredients" class="form-label">Ingrédients (séparés par des virgules) :</label>
                        <input type="text" id="newIngredients" name="newIngredients" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Créer la recette</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>