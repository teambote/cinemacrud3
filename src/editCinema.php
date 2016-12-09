<?php
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . './includes/Manager.php';

session_start();
// si l'utilisateur n'est pas connecté ou sinon s'il n'est pas amdinistrateur
if (!array_key_exists("user", $_SESSION) or $_SESSION['user'] !== 'admin@adm.adm') {
    // renvoi à la page d'accueil
    header('Location: index.php');
    exit;
}

// variable qui sert à conditionner l'affichage du formulaire
$isItACreation = false;

// si la méthode de formulaire est la méthode POST
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST") {

    // on "sainifie" les entrées
    $sanEntries = filter_input_array(INPUT_POST, ['backToList' => FILTER_DEFAULT,
        'cinemaID' => FILTER_SANITIZE_NUMBER_INT,
        'adresse' => FILTER_SANITIZE_STRING,
        'denomination' => FILTER_SANITIZE_STRING,
        'modificationInProgress' => FILTER_SANITIZE_STRING]);

    // si l'action demandée est retour en arrière
    if ($sanEntries['backToList'] !== NULL) {
        // on redirige vers la page des cinémas
        header('Location: cinemasList.php');
        exit;
    }
    // sinon (l'action demandée est la sauvegarde d'un cinéma)
    else {

        // et que nous ne sommes pas en train de modifier un cinéma
        if ($sanEntries['modificationInProgress'] == NULL) {
            // on ajoute le cinéma
            $cinemaMgr->insertNewCinema($sanEntries['denomination'], $sanEntries['adresse']);
        }
        // sinon, nous sommes dans le cas d'une modification
        else {
            // mise à jour du cinéma
            $cinemaMgr->updateCinema($sanEntries['cinemaID'], $sanEntries['denomination'], $sanEntries['adresse']);
        }
        // on revient à la liste des cinémas
        header('Location: cinemasList.php');
        exit;
    }
}// si la page est chargée avec $_GET
elseif (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "GET") {
    // on "sainifie" les entrées
    $sanEntries = filter_input_array(INPUT_GET, ['cinemaID' => FILTER_SANITIZE_NUMBER_INT]);
    if ($sanEntries && $sanEntries['cinemaID'] !== NULL && $sanEntries['cinemaID'] !== '') {
        // on récupère les informations manquantes 
        $cinema = $cinemaMgr->getCinemaInformationsByID($sanEntries['cinemaID']);
    }
    // sinon, c'est une création
    else {
        $isItACreation = true;
        $cinema = [
            'CINEMAID' => '',
            'DENOMINATION' => '',
            'ADRESSE' => ''
        ];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cinéma - Editer un cinéma</title>
        <link rel="stylesheet" type="text/css" href="css/cinema.css"/>
    </head>
    <body>
        <h1>Ajouter/Modifier un cinéma</h1>
        <form method="POST" name="editCinema" action="editCinema.php">
            <label>Dénomination :</label>
            <input name="denomination" type="text" value="<?= $cinema['DENOMINATION'] ?>" required/>
            <label>Adresse :</label>
            <textarea name="adresse" required><?= $cinema['ADRESSE'] ?></textarea>
            <br/>
            <input type="hidden" value="<?= $cinema['CINEMAID'] ?>" name="cinemaID"/>
            <?php
            // si c'est une modification, c'est une information dont nous avons besoin
            if (!$isItACreation) {
                ?>
                <input type="hidden" name="modificationInProgress" value="true"/>
                <?php
            }
            ?>
            <input type="submit" name="saveEntry" value="Sauvegarder"/>
            <input type="submit" name="backToList" value="Retour à la liste"/>
        </form>
    </body>
</html>