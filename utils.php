<?php

//fonction du TD1
function generateHTMLHeader($title, $cssPath) {
    echo <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>$title</title>
             <!-- Bootstrap CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="$cssPath">
        <style>
        .nav-link {
            font-weight: bold;
            transition: color 0.3s, transform 0.3s;
        }
        
    </style>
    </head>
    <body>
    HTML;
}

function generateHTMLFooter() {
    echo <<<HTML
    </body>
    </html>
    HTML;
}

//Fonction du TD2
// Liste des pages autorisées
$page_list = array(
    array("name" => "accueil", "title" => "Accueil de notre site", "menutitle" => "Accueil", "droit" => "1"),
    array("name" => "connexion", "title" => "Connexion", "menutitle" => "Connexion", "droit"=> "0"),
    array("name" => "inscription", "title" => "Inscription", "menutitle" => "S'inscrire", "droit"=> "0"),
    array("name" => "compte", "title" => "Mon compte", "menutitle" => "Mon compte", "droit"=> "2"),
    array("name" => "contact", "title" => "Qui sommes-nous ?", "menutitle" => "Nous contacter", "droit"=> "1"),
);

function checkPage($askedPage) {
    global $page_list;
    foreach ($page_list as $page) {
        if ($page["name"] == $askedPage) {
            return true;
        }
    }
    return false;
}

function getPageTitle($askedPage) {
    global $page_list;
    foreach ($page_list as $page) {
        if ($page["name"] == $askedPage) {
            return $page["title"];
        }
    }
    return "Erreur";
}

function generateMenu($askedPage) {
    global $page_list;
    $userLoggedIn = array_key_exists('loggedIn', $_SESSION) && $_SESSION['loggedIn'];
    echo <<<END
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" style="font-weight: bold;">
                <img src="images/Logo.jpg" alt="Logo" style="height: 30px; margin-right: 10px;">VideTonBE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
END;
    foreach ($page_list as $page) {
        if (($userLoggedIn && $page['droit'] >= 1) || (!$userLoggedIn && $page['droit'] <= 1)) {
            $active = ($page['name'] == $askedPage) ? 'active' : '';
            echo <<<END
                    <li class="nav-item">
                        <a class="nav-link $active" href="index.php?page={$page['name']}">{$page['menutitle']}</a>
                    </li>
END;
        }
    }
    echo <<<END
                </ul>
END;
    if ($userLoggedIn) {
        printLogoutForm();
    }
    echo <<<END
            </div>
        </div>
    </nav>
END;
}
?>