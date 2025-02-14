<?php
class Ingvsrec {

    public string $nom_recette ;
    public int $duree ;
    public string $lien ;
    public array $ingredients;
    
    public function creerRecetteAvecIngredients($dbh, $nom_recette, $duree, $lien, $ingredients) {
        $recette = Recette::getRecette($dbh, $nom_recette);
        if (!$recette) {
            $recette_id = Recette::insererRecette($dbh, $nom_recette, $duree, $lien);
        } else {
            $recette_id = $recette->getIdR();
        }

        foreach ($ingredients as $nom_ingredient) {
            $ingredient = Ingredient::getIngredient($dbh, $nom_ingredient);
            if (!$ingredient) {
                $ingredient_id = Ingredient::insererIngredient($dbh, $nom_ingredient);
            } else {
                $ingredient_id = $ingredient->getId();
            }

            $this->ajouterIngredientARecette($recette_id, $ingredient_id);
        }

        return $recette_id;
    }

    
    private function ajouterIngredientARecette($recette_id, $ingredient_id) {
        $query = "INSERT IGNORE INTO ingvsrec (id_recette, id_ingredient) VALUES (:recette_id, :ingredient_id)";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute([
            ':recette_id' => $recette_id,
            ':ingredient_id' => $ingredient_id
        ]);
    }
}
?>

}