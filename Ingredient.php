<?php
class Ingredient {

public $id;
public $nom;
 
public static function getIngredient($dbh, $nom) {
$query = "SELECT * FROM ingrédients WHERE Nom = ?";
$sth = $dbh->prepare($query);
$sth->setFetchMode(PDO:: FETCH_CLASS, 'Ingredient');
$sth->execute(array($nom));
if ($user = $sth->fetch()){
  return $user;
}
else{
  return null;
}
}

public static function getId($dbh, $nom) {
$query = "SELECT id FROM ingrédients WHERE Nom = ?";
$sth = $dbh->prepare($query);
$sth->setFetchMode(PDO:: FETCH_CLASS, 'Ingredient');
$sth->execute(array($nom));
if ($user = $sth->fetch()){
  return $user;
}
else{
  return null;
}
}

static function insererIngredient($dbh, $nom) {
 if(Ingredient:: getIngredient($dbh, $nom)==null){
    $query = "INSERT INTO ingrédients(nom) VALUES (?)";
    $sth = $dbh->prepare ($query);
    $sth->execute (array($nom));
    return ($sth->rowCount ()==1);
}
return false;
}

}

