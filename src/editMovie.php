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
        'filmID' => FILTER_SANITIZE_NUMBER_INT,
        'titre' => FILTER_SANITIZE_STRING,
        'titreOriginal' => FILTER_SANITIZE_STRING,
        'modificationInProgress' => FILTER_SANITIZE_STRING]);

    // si l'action demandée est retour en arrière
    if ($sanEntries['backToList'] !== NULL) {
        // on redirige vers la page des films
        header('Location: moviesList.php');
        exit;
    }
    // sinon (l'action demandée est la sauvegarde d'un film)
    else {

        // et que nous ne sommes pas en train de modifier un film
        if ($sanEntries['modificationInProgress'] == NULL) {
            // on ajoute le film
            $filmMgr->insertNewMovie($sanEntries['titre'], $sanEntries['titreOriginal']);
        }
        // sinon, nous sommes dans le cas d'une modification
        else {
            // mise à jour du film
            $filmMgr->updateMovie($sanEntries['filmID'], $sanEntries['titre'], $sanEntries['titreOriginal']);
        }
        // on revient à la liste des films
        header('Location: moviesList.php');
        exit;
    }
}// si la page est chargée avec $_GET
elseif (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "GET") {
    // on "sainifie" les entrées
    $sanEntries = filter_input_array(INPUT_GET, ['filmID' => FILTER_SANITIZE_NUMBER_INT]);
    if ($sanEntries && $sanEntries['filmID'] !== NULL && $sanEntries['filmID'] !== '') {
        // on récupère les informations manquantes 
        $film = $filmMgr->getMovieInformationsByID($sanEntries['filmID']);
    }
    // sinon, c'est une création
    else {
        $isItACreation = true;
        $film = [
            'FILMID' => '',
            'TITRE' => '',
            'TITREORIGINAL' => ''
        ];
    }
}
require 'views/viewEditMovie.php';