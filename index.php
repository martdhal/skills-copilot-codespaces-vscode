<?php
session_name("MaganMythe");
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;}
    
require('utilities/utils.php');
require('Database.php');
require('utilities/PrintForms.php');
require('Utilisateur.php');
require('Utilities/logInOut.php');
require('utilities/recette.php');
require('utilities/ingvsrec.php');
require('utilities/Ingredient.php');


// Connexion à la base de données
$dbh = Database::connect();

if(array_key_exists('todo', $_GET) && $_GET['todo']=='login'){
    echo "tentative login";
    logIn($dbh);
}

if(array_key_exists('todo', $_GET) && $_GET['todo']=='logout'){
    logOut($dbh);
}



// Récupération du paramètre 'page'
$askedPage = isset($_GET['page']) ? $_GET['page'] : 'accueil'; //donne une valeur par defaut

// Vérification de la validité de la page demandée
$authorized = checkPage($askedPage);

// Récupération du titre de la page
$pageTitle = $authorized ? getPageTitle($askedPage) : 'Erreur';

// Génération de l'en-tête HTML
generateHTMLHeader($pageTitle, 'css/bootstrap.min.css.css');
?>
    <div class="container-fluid">
         <?php
            generateMenu($askedPage);
           ?>
   
    
        <!--photo de fond d'écran-->
        <div class="p-5 mb-4 bg-light rounded-3" style="position: relative;  text-align: center;">
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('images/cuisine.jpg'); background-size: cover; background-position: center; opacity: 0.4; z-index: 0;"></div>
            <div class="container-fluid py-5" style="position: relative; z-index: 1;">
                <h1 class="display-5 fw-bold"><?php echo $pageTitle; ?></h1>
            </div>
        </div>

        <div id="content"> <!<!-- contenu de chaque page -->
        <?php
        if ($authorized) {
            $contentFile = "content/content_$askedPage.php";
            if (file_exists($contentFile)) {
                require($contentFile);
            } else {
                echo '<p>Désolé, le contenu de la page demandée est introuvable.</p>';
            }
        } 
        
        ?>
        </div>

            <div id="footer" class="bg-success text-white text-center py-3 mt-4">
            <p class="mb-0">Site réalisé en Modal par Jean Bassili et Martin d'Halloy</p>
        </div>
    </div>

<?php
// Génération du pied de page HTML
generateHTMLFooter();
$dbh=null;
?>