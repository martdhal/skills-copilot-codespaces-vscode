<?php
class Utilisateur {

public $login;
public $nom;
public $prenom;
public $mdp;

public function __toString () {
return "[{$this->login}] {$this->nom} {$this->prenom}";
}

//retourne objet de la classe avec ce login s'il existe sinon renvoie null
public static function getUtilisateur($dbh, $login) {
$query = "SELECT * FROM utilisateurs WHERE login = ?";
$sth = $dbh->prepare($query);
$sth->setFetchMode(PDO:: FETCH_CLASS, 'Utilisateur');
$sth->execute(array($login));
if ($user = $sth->fetch()){
  return $user;
}
else{
  return null;
}
}


//vérifie si le login n'est pas pris et si oui l'insère dans la BD; renvoie vrai ou faux selon public
public static function insererUtilisateur ($dbh, $login, $mdp, $nom, $prenom) {
if (Utilisateur:: getUtilisateur ($dbh, $login)==null){
    $query = "INSERT INTO utilisateurs(login,mdp,nom,prenom) VALUES (?,?,?,?)";
    $sth = $dbh->prepare ($query);
    $sth->execute (array($login,sha1 ($mdp), $nom, $prenom));
    return ($sth->rowCount ()==1);
}
return false;
}
//vérifie si le mdp correspond à celui de l'utilisateur
public function testerMDP($dbh, $mdp) {
$query = "SELECT * FROM utilisateurs WHERE login = ? AND mdp = ?";
$sth = $dbh->prepare ($query);
$sth->execute(array($this->login,
sha1($mdp)));
return ($sth->rowCount () ==1);
}
//met à jour le mdp d'un utilisateur et renvoie vrai ou faux si ça a marché
public function updateMDP ($dbh, $mdp) {
    $query = "UPDATE utilisateurs SET mdp=? WHERE login=?";
    $sth = $dbh->prepare ($query);
    $sth->execute(array (sha1($mdp) , $this->login));
}


}