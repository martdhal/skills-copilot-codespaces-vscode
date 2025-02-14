<?php
$error='';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Récupérer les informations de connexion
    $login = $_POST['login'];
    $password =($_POST['password']); 

    // Vérifier si l'utilisateur existe
    $user = Utilisateur::getUtilisateur($dbh, $login);

    if ($user && $user->testerMDP($dbh, $password)) {
        // Mot de passe correct, connecter l'utilisateur
        $_SESSION['loggedIn'] = true;
        $_SESSION['login'] = $login;
    } 
    else {
        $error= "Login ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="background-color: #2c8a4e; color: #fff; max-width: 350px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Connexion</h4>
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form action="index.php?page=compte&todo=login" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Login:</label>
                        <input id="login" type="text" class="form-control" required name="login">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe:</label>
                        <input id="password" type="password" class="form-control" required name="password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>