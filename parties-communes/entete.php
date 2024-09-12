<?php
    // Énumérer le contenu d'un dossier
    //$contenu = scandir ('i18n');
    //print_r($contenu);

    // Créer un tableau des codes de langues disponibles

    $languesDispo = [];

    // Remplir le tableau avec les codes obtenus des noms des fichiers JSON
    // présents dans e dossier i18n
    $contenuI18n = scandir('i18n');

    // Solution 1 : avec une boucle standard (avec compteur)
    // donc du ocde dit "impératif" (moins souhaitable)

    // for ($i = 0; $i <count($contenuI18n); $i++){
    //     $fichier = $contenuI18n[$i];

    //     // Si le ficher n'est pas '.' ou '..' 
    
    // if ($fichier != '.' && $fichier != '..'){

    //     $languesDispo[] = substr($fichier, 0, 2);
    //}
//}

// Solution 2 : avec une boucle "itérable" ( sans compteur )
// Donc du code dit "expressif" ou "déclaratif" (plus souhaitable)
// (En JavaScript, cette boucle est similaire à for...of)

foreach($contenuI18n as $nomFichier) {

    // Pas une bonen stratégie : il faut filtrer
    // Tout ce qui ne ressemble pas à 'll.json' (où 'll' sont deux lettres)
    // Solution possible serait d'utiliser les expressions régulières (RegExp)
    if ($nomFichier != '.' && $nomFichier != '..' ){
        $languesDispo[] = substr($nomFichier,0,2);
    }
}

    // Test : afficher lMinfo sur le tableau des langues disponibles
    //print_r($languesDispo);

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

    // ATTENTION : code susceptible d'injection !!!!!
    // Programmez défensivement !!!
    // Ne faites pas confiance à ce qui vient de l'utilisateur


     if(isset($_COOKIE['choixLangue'])
         && in_array($_COOKIE['choixLangue'], $languesDispo)){
      $langue =$_COOKIE['choixLangue'];  
     }

    
    // 3. Langue spéficiée dans l'URL ( ca veut dire l'utilisateur a )
    

    // ATTENTION : programmez défensivement !!!
    // Ne jamais faire confiance aux valeurs qui viennent du UI (utilisateur)
    if (isset($_GET['lan']) && in_array($_GET['lan'], $languesDispo)){
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
<html lang="<?= $langue ?>" dir = "ltr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;900&family=Noto+Serif:ital,wght@0,400;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_-> metaTitre ?></title>
    <meta name="description" content="<?= $_->metaDesc ?>">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="images/favicon.png" />
</head>
<body>
    <div class="conteneur">
        <header>
            <nav class="barre-haut">
    <!-- Générer un 'bouton' (lien HTML) pour chaque code de langue dans le tableau $languesDispo !-->

        <!-- Début boucle !-->


        <?php foreach($languesDispo as $codeLangue) :  ?>

                <a 
                class="<?php if($langue == $codeLangue){echo 'actif';} ?>" 
                href="?lan=<?= $codeLangue ?>"
                title = "A venir">
                
                
                <?= $codeLangue ?>

                </a>
     <?php endforeach  ?>
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