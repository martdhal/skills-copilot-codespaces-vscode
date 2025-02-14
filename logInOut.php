

<?php

//récupère le login et mdp dans le $_POST et tente la connexion
function logIn($dbh){
    var_dump($_POST);
    if(array_key_exists('login', $_POST) && array_key_exists('password', $_POST)){
        $login= $_POST['login'];
        $mdp=$_POST['password'];
        $user= Utilisateur ::getUtilisateur($dbh, $login);
        if((! $user==null) && $user ->testerMDP($dbh,$mdp)){
            $_SESSION['loggedIn'] = true;
            $_SESSION['login']=$login;
        }
    }
}

//effectue la deconnexion
function logOut() {
   $_SESSION['loggedIn']=false;
   unset($_SESSION['login']);
}
?>