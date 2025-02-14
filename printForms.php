<?php

//génère le formulaire de login
function printLoginForm($askedPage){
    echo <<<END
                <form class='form-inline my-2 my-1g-0' action='index.php?page=$askedPage&todo=login' method='POST'>
                    <input class='form-control mr-sm-2' type='text' placeholder='Login' name='login'> 
                    <input class='form-control mr-sm-2' type='password' placeholder='Mot de passe' name='mdp>
                    <button class='btn btn-outline-light my-2 my-sm-0' type='submit'>Connexion</button>
                </form>
                
    
END;  
}


//génère le formulaire de déconnexion
function printLogoutForm() {
   echo <<<END
    <div class="position-absolute top-0 end-0 m-3">
        <form action="index.php?todo=logout" method="post">
            <button type="submit" class="btn btn-danger btn-sm">Se déconnecter</button>
        </form>
    </div>
END;
}
?>