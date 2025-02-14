<?php
class recette {

    public $nom;
    public $duree;
    public $lien;

    public static function getRecette($dbh, $nom) {
        $query = "SELECT * FROM recette WHERE nom = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO:: FETCH_CLASS, 'recette');
        $sth->execute(array($nom));
        if ($user = $sth->fetch()){
            return $user;
        }
        else{
            return null;
        }
    }

    public static function getIdr($dbh, $nom) {
        $query = "SELECT id FROM recette WHERE nom = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO:: FETCH_CLASS, 'recette');
        $sth->execute(array($nom));
        if ($user = $sth->fetch()){
            return $user;
        }
        else{
            return null;
        }
    }

    static function insererRecette($dbh, $nom, $duree, $lien) {
        if(self::getRecette($dbh, $nom) == null){
            $query = "INSERT INTO recette(nom, duree, lien) VALUES (?,?,?)";
            $sth = $dbh->prepare ($query);
            if ($sth->execute(array($nom, $duree, $lien))) {
                return ($sth->rowCount() == 1);
            } else {
                // Afficher l'erreur SQL
                print_r($sth->errorInfo());
                return false;
            }
        }
        return false;
    }

    static function trouverRecette($dbh, $ingredients) {
        if (empty($ingredients)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($ingredients), '?'));
        $query = "SELECT r.nom AS recette, r.lien AS Lien
                  FROM recette r
                  JOIN (
                      SELECT ir.id_rec
                      FROM ingvsrec ir
                      JOIN ingrédients i ON i.id = ir.id_ing
                      WHERE i.nom IN ($placeholders)
                      GROUP BY ir.id_rec
                      HAVING COUNT(DISTINCT ir.id_ing) >= 3
                  ) AS filtered_recipes ON r.id = filtered_recipes.id_rec
                  ORDER BY r.nom;";
        $sth = $dbh->prepare($query);
        $sth->execute($ingredients);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}