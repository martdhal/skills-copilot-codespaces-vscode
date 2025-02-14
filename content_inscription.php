<div class="jumbotron">
<h1>M'inscrire sur le site</h1> 
<p>Il n'y a qu'à compléter le formulaire ci-dessous</p>
</div>

<?php


$nom = "";
if (array_key_exists( 'nom', $_POST)) {
$nom = $_POST['nom'];
}

$prenom = "";
if (array_key_exists( 'prenom', $_POST)) {
$prenom = $_POST[ 'prenom' ];
}

$ok = false;
$tentative = false;
if (array_key_exists('login',$_POST) && !$_POST['login'] == "" && array_key_exists('up',$_POST) && array_key_exists('up2',$_POST) && $_POST['up'] == $_POST['up2']){
   $tentative = true; 
   $ok = Utilisateur:: insererUtilisateur($dbh,$_POST['login'], $_POST['up'], $_POST['nom'], $_POST['prenom']);
}

if ($ok){
echo "<h3 class='text-success'>Inscription réussie! Veuillez vous connecter</h3>";
}
else{
if ($tentative){
    echo "<h3 class='text-success'>login existant !</h3>";
}
else{
    if(array_key_exists('login',$_POST) && !$_POST['login']== ""){
        echo "<h3 class='text-danger'>Erreur de mot de passe</h3>";
      
    }
}
}


echo<<<FIN
<div class="container mt-5">
        <div class="card bg-success text-white mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Créer un compte</h4>
                <form action="index.php?page=inscription&todo=inscription" method="post"
                      oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">
                    <div class="mb-3">
                        <label for="login" class="form-label">Login:</label>
                        <input id="login" type="text" class="form-control" required name="login" >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input id="email" type="email" class="form-control" required name="email" >
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input id="nom" type="text" class="form-control" required name="nom" value="$nom">
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input id="prenom" type="text" class="form-control" required name="prenom" value="$prenom">
                    </div>
                    <div class="mb-3">
                        <label for="password1" class="form-label">Password:</label>
                        <input id="password1" type="password" class="form-control" required name="up">
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Confirm password:</label>
                        <input id="password2" type="password" class="form-control" required name="up2">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Create account</button>
                </form>
            </div>
        </div>
    </div>
            
FIN;

?>