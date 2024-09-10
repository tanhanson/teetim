<?php
    // Énumérer le contenu d'un dossier
    //$contenu = scandir ('i18n');
    //print_r($contenu);

    // Créer un tableau des codes de langues disponibles

    $languesDispo = [];

    // Remplir le tableau avec les codes obtenus des noms des fichiers JSON
    // présents dans e dossier i18n
    $contenuI18n = scandir('i18n');

    for ($i = 0; $i <count($contenuI18n); $i++){
        $fichier = $contenuI18n[$i];
    
    if ($fichier != '.' && $fichier != '..'){

        $languesDispo[] = substr($fichier, 0, 2)."<br>";
    }
}
    // Test : afficher lMinfo sur le tableau des langues disponibles
    print_r($languesDispo);

    // Test : le "timestamp" de maintenant
    //echo time ();

    // setcookie('patati', 'patata', time() +700*24*3600);
    // Test : la "jarre de cookies" envoyée par le "browser
    //print_r($_COOKIE);


    // Déterminer le choix de lamgue de l'utilisateur
    //print_r($_GET);

    // 1. Langue par défaut
    $langue = 'fr';

    // 2. Langue mémorisée dans un témoin HTTP (s'il existe !!!)

     if(isset($_COOKIE['choixLangue'])){
      $langue =$_COOKIE['choixLangue'];  
     }

    
    // 3. Langue spéficiée dans l'URL ( ca veut dire l'utilisateur a )
    if (isset($_GET['lan'])){
        $langue = $_GET ['lan'];

        // Mémoriser ce choix de langue
        // DONC : stocker la valeur du code de langue dans un témoin HTTP
        setcookie('choixLangue', $langue, time()+30 *24*3600 );

        //setcookie('unAutreTest', 'widjaodjasidadawdasdawdiad', time ()+10);

        //setcookie('patati', '', time()-1);


    }
    
    //echo $langue;
    
    // Lire le fichier JSON contenant les textes
    // Étape 1 : "lire" le fichier "i18n/fr.json"
    // et affecter son contenu 
    $textesJSON = file_get_contents("i18n/" . $langue . ".json");
    // Test :
    // echo $textes;

    // Étape 2 : convertir le contenu JSON du fichier en variables PHP utilisables
    // pour remettre les textes dans la page Web aux bons endroits.
    $textes = json_decode($textesJSON);

    // Raccourci pour les parties communes
    $_ent = $textes -> entete;
    $_pp = $textes -> pp;

    // Raccourci pour les pages spécifiques

    $_ = $textes -> $page;
    // Test

    //print_r($textesConvertis);
    // Imprimer la propriété altLogo de l'objet correspondant à la propriété
    // entête de cet objet :
    //echo $textes->entete->altLogo;
    //echo $textes->entete->placeholderRecherche;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;900&family=Noto+Serif:ital,wght@0,400;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teeTIM // fibre naturelle ... conception artificielle</title>
    <meta name="description" content="Page d'accueil du concepteur de vêtements 100% fait au Québec, conçus par les étudiants du TIM à l'aide de designs produits par intelligence artificielle, et fabriqués avec des fibres 100% naturelles et biologiques.">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="images/favicon.png" />
</head>
<body>
    <div class="conteneur">
        <header>
            <nav class="barre-haut">
    <!-- Générer un 'bouton' (lien HTML) pour chaque code de langue dans le tableau $languesDispo !-->

        <!-- Début boucle !-->
                <a 
                class="<?php if($langue == 'fr'){echo 'actif';} ?>" 
                href="?lan=fr"
                >
                fr

                </a>

                  <!-- Fin boucle !-->
            </nav>

            <nav class="barre-logo">
                <label for="cc-btn-responsive" class="material-icons burger">menu</label>
                <a class="logo" href="index.php"><img src="images/logo.png" alt="<?php echo $textes->entete->altLogo; ?>"></a>
                <a class="material-icons panier" href="panier.php">shopping_cart</a>
                <input class="recherche" type="search" name="motscles" placeholder="<?php echo $textes-> entete->placeholderRecherche;?>">
            </nav>
            <input type="checkbox" id="cc-btn-responsive">
            <nav class="principale">
                <label for="cc-btn-responsive" class="menu-controle material-icons">close</label>
                <a href="teeshirts.php" class="<?php if($page=='teeshirts'){  echo 'actif'; } ?>"><?=  $_ent ->menuTeeshirts; ?></a>
                <a href="casquettes.php"> <?= $_ent-> menuCasquettes;?></a>
                <a href="hoodies.php"> <?= $_ent-> menuHoodies; ?> </a>
                <span class="separateur"> </span>
                <a href="aide.php"> <?= $_ent-> menuAide; ?></a>
                <a href="apropos.php"> <?= $_ent-> menuNous ?></a>
            </nav>
        </header>